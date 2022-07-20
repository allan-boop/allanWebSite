<?php
namespace App\Command;

use App\Repository\FormulaireContactRepository;
use App\Repository\AllanRepository;
use App\Service\ContactService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SendContactCommand extends Command
{
    private $contactRepository;
    private $mailer;
    private $contactService;
    private $allanRepository;
    protected static $defaultName = 'app:send-contact';

    public function __construct(
        FormulaireContactRepository $contactRepository,
        MailerInterface $mailer,
        ContactService $contactService,
        AllanRepository $allanRepository
    ) {
        $this->contactRepository = $contactRepository;
        $this->mailer = $mailer;
        $this->contactService = $contactService;
        $this->allanRepository = $allanRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $toSend = $this->contactRepository->findBy(['isSend' => false]);
        $adress = new Address(
            $this->allanRepository->findOneBy(['prenom' => 'Allan'])->getMail(),
            $this->allanRepository
                ->findOneBy(['prenom' => 'Allan'])
                ->getPrenom()
        );

        foreach ($toSend as $mail) {
            $email = (new Email())
                ->from($mail->getMail())
                ->to($adress)
                ->subject('Nouveau message de' . $mail->getNom())
                ->text($mail->getMessage());

            $this->mailer->send($email);

            $this->contactService->isSend($mail);
        }

        return Command::SUCCESS;
    }
}
