<?php

namespace App\WalletManagement\Infrastructure;

use App\WalletManagement\Presentation\WalletListView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\WalletManagement\Domain\WalletRepositoryInterface;
use App\Shared\Infrastructure\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shared\Infrastructure\CommandBusInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\WalletManagement\Application\Query\FindAllWalletsQuery;
use App\WalletManagement\Application\Command\CreateWalletCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/wallet')]
class WalletController extends AbstractController
{
    public function __construct(
        public WalletRepositoryInterface $walletRepository,
        public SerializerInterface $serializer,
        public CommandBusInterface $commandBus,
        public QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/', name: 'api_wallet_index', methods: ['GET'])]
    public function index(FindAllWalletsQuery $query): Response
    {
        /** @var $view WalletListView */
        $view = $this->queryBus->handle($query);

        return new JsonResponse($view->showWallets(), Response::HTTP_OK);
    }

    #[Route('/', name: 'api_wallet_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $createWalletCommand = $this->serializer
            ->deserialize($request->getContent(), CreateWalletCommand::class, 'json');
        $this->commandBus->handle($createWalletCommand);
//        $getWalletQuery =

        return new JsonResponse([], Response::HTTP_CREATED);
    }

    #[Route('/{id}/balance', name: 'api_wallet_balance', methods: ['GET'])]
    public function getBalance(Request $request): Response
    {
//        $decodedBody = json_decode($request->getContent(), true);
//        $requestData = ['id' => Uuid::fromString($request->get('id')), ...$decodedBody];
//
//        dd($requestData);
//        $query = new GetBalanceQuery();
        return new JsonResponse(['balance' => []], Response::HTTP_OK);
    }

    #[Route('/{id}/balance/add', name: 'api_wallet_balance_add', methods: ['PUT'])]
    public function addBalance(int $id): Response
    {
        return new JsonResponse(['wallet_id' => $id], Response::HTTP_OK);
    }

    #[Route('/{id}/balance/subtract', name: 'api_wallet_balance_subtract', methods: ['PUT'])]
    public function subtractBalance(int $id): Response
    {
        return new JsonResponse(['wallet_id' => $id], Response::HTTP_OK);
    }
}
