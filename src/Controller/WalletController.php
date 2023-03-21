<?php

namespace App\Controller;

use App\Model\Entity\Wallet;
use App\Model\ValueObject\Balance;
use App\Repository\WalletRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/wallet')]
class WalletController extends AbstractController
{
    public function __construct(
        public WalletRepository $walletRepository,
        public ValidatorInterface $validator
    ) {
    }

    #[Route('/', name: 'api_wallet_index', methods: ['GET'])]
    public function index(): Response
    {
        return new JsonResponse($this->walletRepository->findAll(), Response::HTTP_OK);
    }

    #[Route('/', name: 'api_wallet_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $wallet = new Wallet();
        $wallet->setName($request->get('name'));
        $balance = new Balance(
            $request->get('balance_value'),
            $request->get('balance_currency'),
        );
        $wallet->setBalance($balance);
        $this->validator->validate($wallet);

        return new JsonResponse(['new_wallet' => true], Response::HTTP_CREATED);
    }

    #[Route('/{id}/balance', name: 'api_wallet_balance', methods: ['GET'])]
    public function getBalance(Wallet $wallet): Response
    {
        return new JsonResponse(['balance' => $wallet->getBalance()], Response::HTTP_OK);
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
