<?php

namespace App\Controller;

use App\DTO\ClientDataDTO;
use App\DTO\ItemCompanyItemDTO;
use App\DTO\UserCompanyInvoiceCreatedReturnDataDTO;
use App\Entity\Invoice;
use App\Repository\CompanyRepository;
use App\Repository\InvoiceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TCPDF;


class InvoiceController extends AbstractController
{
    private $manager;
    private $invoice;


    public function __construct(EntityManagerInterface $manager, InvoiceRepository $invoice)
    {
        $this->manager = $manager;

        $this->invoice = $invoice;
    }

    #[Route('/invoice/{userId}/{companyId}', name: 'app_invoice', methods: 'POST')]
    public function addInvoice(Request $request, $userId, $companyId, UserRepository $userRepository, CompanyRepository $companyRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $userRepository->find($userId);
        $company = $companyRepository->find($companyId);

        $tabItem = ['nameItem' => $data['nameItem'], 'description' => $data['description'], 'quantity' => $data['quantity'], 'price' => $data['price'],
            'unit' => $data['unit']];

        $tabClient = ['nameClient' => $data['nameClient'], 'street' => $data['street'], 'city' => $data['city'], 'zip' => $data['zip'], 'state' => $data['state']];

        $userData = ['id' => $user->getId(), 'email' => $user->getEmail(), 'role' => $user->getRoles()];

        $itemData = new ItemCompanyItemDTO($data['nameItem'], $data['description'], $data['quantity'], $data['price'], $data['unit']);

        $clientData = new ClientDataDTO($data['nameClient'], $data['street'], $data['city'], $data['zip'], $data['state']);


        $invoice = new Invoice();
        $invoice->setCompanyData($company->getData());
        $invoice->setPaymentMethod($company->getPaymentData());
        $invoice->setClientData($tabClient);
        $invoice->setItemsData($tabItem);
        $invoice->setNote("test");


        $this->manager->persist($invoice);
        $this->manager->flush();

        $pdfUrl = $this->generateUrl('generateInvoice',['invoiceId' => $invoice->getId()], true);
        $returnData = new UserCompanyInvoiceCreatedReturnDataDTO($pdfUrl, $userData, $company->getData(), $itemData, $clientData);

        return ($this->json($returnData));
    }

    #[Route('/generateInvoice/{invoiceId}', name: 'generateInvoice', methods: 'GET')]
    public function generateInvoice($invoiceId, InvoiceRepository $invoiceRepository): Response
    {
        $invoice = $invoiceRepository->find($invoiceId);
        $html = $this->render('index.html.twig', ['client' => $invoice->getClientData(), 'item' => $invoice->getItemsData(), 'Nbr' => $invoiceId,
            'company' => $invoice->getCompanyData(), 'payment' => $invoice->getPaymentMethod()]);
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
        $pdf->AddPage();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Invoice_nbr ' . $invoiceId);
        $pdf->SetSubject('INVOICES');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->writeHTML($html);
        $pdfPath = 'pdf/' . uniqid() . '.pdf';
        $pdf->Output('invoice.pdf', 'I');
        $pdfUrl = $this->generateUrl('print_invoice', ['filename' => basename($pdfPath)], true);
        return $this->redirectToRoute('print_invoice', ['filename' => basename($pdfPath)]);

    }



    #[Route('/printInvoice/', name: 'print_invoice', methods: 'GET')]
    public function viewPdfAction(string $filename): Response
    {
        $pdfPath = 'pdf/' . $filename; // Change 'pdf/' to the actual path where you saved the PDF

        // Check if the PDF file exists
        if (!file_exists($pdfPath)) {
            throw $this->createNotFoundException('The PDF file does not exist');
        }

        // Return the PDF file as a response
        return new Response(file_get_contents($pdfPath), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
    #[Route('/test/{invoiceId}', name: 'test', methods: 'GET')]
    public function test($invoiceId, InvoiceRepository $invoiceRepository)
    {
        $invoice = $invoiceRepository->find($invoiceId);
       return$this->render('index.html.twig', ['client' => $invoice->getClientData(), 'item' => $invoice->getItemsData(), 'Nbr' => $invoiceId,
            'company' => $invoice->getCompanyData(), 'payment' => $invoice->getPaymentMethod()]);

    }
}
