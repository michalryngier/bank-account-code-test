<?php

namespace App\WalletManagement\Infrastructure;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Shared\Infrastructure\QueryBusInterface;
use App\WalletManagement\Presentation\WalletView;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shared\Infrastructure\CommandBusInterface;
use App\WalletManagement\Presentation\WalletListView;
use Symfony\Component\Serializer\SerializerInterface;
use App\Shared\Domain\Exception\WalletNotFoundException;
use App\WalletManagement\Application\Query\GetWalletQuery;
use App\WalletManagement\Application\Query\GetBalanceQuery;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use App\WalletManagement\Application\Query\FindAllWalletsQuery;
use App\WalletManagement\Application\Command\CreateWalletCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use App\WalletManagement\Application\Command\IncreaseBalanceCommand;
use App\WalletManagement\Application\Command\DecreaseBalanceCommand;

#[Route('/wallets')]
class WalletController extends AbstractController
{
    public function __construct(
        public SerializerInterface $serializer,
        private readonly DenormalizerInterface $denormalizer,
        public CommandBusInterface $commandBus,
        public QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/', name: 'api_wallet_index', methods: ['GET'])]
    public function index(FindAllWalletsQuery $query): Response
    {
        /** @var $walletsView WalletListView */
        $walletsView = $this->queryBus->handle($query);

        return new JsonResponse($walletsView->showWallets(), Response::HTTP_OK);
    }

    #[Route('/', name: 'api_wallet_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        /* @var $createWalletCommand CreateWalletCommand */
        $createWalletCommand = $this->serializer
            ->deserialize($request->getContent(), CreateWalletCommand::class, 'json');
        $this->commandBus->handle($createWalletCommand);
        $getWalletQuery = new GetWalletQuery($createWalletCommand->getId());
        /* @var $walletView WalletView */
        $walletView = $this->queryBus->handle($getWalletQuery);

        return new JsonResponse($walletView->showWalletId(), Response::HTTP_CREATED);
    }

    /**
     * @throws ExceptionInterface
     * @throws WalletNotFoundException
     */
    #[Route('/{id}/balance', name: 'api_wallet_balance', methods: ['GET'])]
    public function getBalance(Request $request): Response
    {
        $requestData = ['id' => Uuid::fromString($request->get('id'))];
        $getWalletBalanceQuery = $this->denormalizer->denormalize($requestData, GetBalanceQuery::class);
        /* @var $walletView WalletView */
        $walletView = $this->queryBus->handle($getWalletBalanceQuery);

        $walletNotFound = is_null($walletView);
        WalletNotFoundException::throwWhen($walletNotFound, $getWalletBalanceQuery->getId());

        return new JsonResponse($walletView->showWalletBalance(), Response::HTTP_OK);
    }

    /**
     * @throws ExceptionInterface
     * @throws WalletNotFoundException
     */
    #[Route('/{id}/deposit', name: 'api_wallet_balance_add', methods: ['PUT'])]
    public function increaseBalance(Request $request): Response
    {
        $decodedBody = json_decode($request->getContent(), true);
        $requestData = ['id' => Uuid::fromString($request->get('id')), ...$decodedBody];

        $increaseBalanceCommand = $this->denormalizer->denormalize($requestData, IncreaseBalanceCommand::class, 'json');
        $this->commandBus->handle($increaseBalanceCommand);

        $getWalletQuery = new GetWalletQuery($increaseBalanceCommand->getId());
        /* @var $walletView WalletView */
        $walletView = $this->queryBus->handle($getWalletQuery);

        $walletNotFound = is_null($walletView);
        WalletNotFoundException::throwWhen($walletNotFound, $increaseBalanceCommand->getId());

        return new JsonResponse($walletView->showWalletBalance(), Response::HTTP_OK);
    }

    /**
     * @throws ExceptionInterface
     * @throws WalletNotFoundException
     */
    #[Route('/{id}/withdraw', name: 'api_wallet_balance_subtract', methods: ['PUT'])]
    public function decreaseBalance(Request $request): Response
    {
        $decodedBody = json_decode($request->getContent(), true);
        $requestData = ['id' => Uuid::fromString($request->get('id')), ...$decodedBody];

        $decreaseBalanceCommand = $this->denormalizer->denormalize($requestData, DecreaseBalanceCommand::class, 'json');
        $this->commandBus->handle($decreaseBalanceCommand);

        $getWalletQuery = new GetWalletQuery($decreaseBalanceCommand->getId());
        /* @var $walletView WalletView */
        $walletView = $this->queryBus->handle($getWalletQuery);

        $walletNotFound = is_null($walletView);
        WalletNotFoundException::throwWhen($walletNotFound, $decreaseBalanceCommand->getId());

        return new JsonResponse($walletView->showWalletBalance(), Response::HTTP_OK);
    }
}
