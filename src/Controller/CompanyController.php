<?php

namespace App\Controller;

use App\DTO\BankTransfereCompanyPaymentDTO;
use App\DTO\CompanyDataDTO;
use App\DTO\CompanyPaymentDataDTO;
use App\DTO\CompanyTemplateDataDTO;
use App\DTO\PaypalCompanyPaymentDTO;
use App\DTO\UserCompanyCreatedReturnDataDTO;
use App\DTO\UserLoginReturnDataDTO;
use App\Entity\Company;
use App\Entity\User;
use App\Entity\Enum\language;

use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

class CompanyController extends AbstractController
{
    private $manager;
    private $company;


    public function __construct(EntityManagerInterface $manager, CompanyRepository $company)
    {
        $this->manager = $manager;

        $this->company = $company;
    }

    #[Route('/company/{idUser}', name: 'app_company')]
    public function index(Request $request, $idUser, UserRepository $userRepository,): JsonResponse


    {


        $user = $userRepository->find($idUser);
        $data = json_decode($request->getContent(), true);


        $base64Image = $data['signature'];



        $imageData = base64_decode($base64Image);


        $fileName = uniqid() . '.png';

        $tmpFilePath = sys_get_temp_dir() . '/' . $fileName;
        file_put_contents($tmpFilePath, $imageData);

        $imageFile = new File($tmpFilePath);

        $imageFile->move('public/uploads', $fileName);

        $tabCom = ['name' => $data['name'], 'street' => $data['street'], 'streetExtraInfo' => ['streetExtraInfo'], 'zip' => $data['zip'],
            'city' => $data['city'], 'ico' => $data['ico'], 'dic' => $data['dic'], 'icDph' => $data['icDph'], 'registryInfo' => $data['registryInfo'],
            'contactName' => $data['contactName'],
            'contactPhone' => $data['contactPhone'], 'contactEmail' => $data['contactEmail'], 'contactWeb' => $data['contactWeb'],
            'logo' => $data['logo'],
            'signature' => $fileName, 'state' => $data['state'], 'typeid' => $data['typeid']];


        $tabPay = ['email' => $data['email'], 'nameBank' => $data['nameBank'], 'numberPrefix' => $data['numberPrefix'],
            'number' => $data['number'], 'code' => $data['code'], 'iban' => $data['iban'], 'SWIFT' => $data['SWIFT']];
        $tabTmp = ['color' => $data['color'],
            'template' => $data['template'],
            'showUnit' => $data['showUnit'],
            'shopTax' => $data['shopTax'],
            'showSku' => $data['showSku'],
            'dueDate' => $data['dueDate'],
            'paymentMethod' => $data['paymentMethod'],
            'productDiscount' => $data['productDiscount'],
            'ownTextSize' => $data['ownTextSize'],
            'currency' => $data['currency'],
            'language' => $data['language'],
            'defaultDueDate' => $data['defaultDueDate'],
            'defaultDeliveryDate' => $data['defaultDeliveryDate'],
            'defaultDocumentNumberAsVariableSymbol' => $data['defaultDocumentNumberAsVariableSymbol'],
            'defaultConstantSymbol' => $data['defaultConstantSymbol'],
            'nextInvoiceNumber' => $data['nextInvoiceNumber'],
            'nextInvoiceNumberFormat' => $data['nextInvoiceNumberFormat']];


        $companyData = new CompanyDataDTO($data['name'], $data['street'], $data['streetExtraInfo'], $data['zip'], $data['city'],
            $data['ico'], $data['dic'], $data['icDph'], $data['registryInfo'], $data['contactName'], $data['contactPhone'],
            $data['contactEmail'], $data['contactWeb'], $data['logo'], $fileName, $data['state'], $data['typeid']);

        $paypalCompany = new PaypalCompanyPaymentDTO($data['email']);
        $bankCompany = new BankTransfereCompanyPaymentDTO($data['nameBank'], $data['numberPrefix'],
            $data['number'], $data['code'], $data['iban'], $data['SWIFT']);
        $paymentData = new CompanyPaymentDataDTO($bankCompany, $paypalCompany);
        $templateData = new CompanyTemplateDataDTO($data['color'],
            $data['template'],
            $data['showUnit'],
            $data['shopTax'],
            $data['showSku'],
            $data['dueDate'],
            $data['paymentMethod'],
            $data['productDiscount'],
            $data['ownTextSize'],
            $data['currency'],
            $data['language'],
            $data['defaultDueDate'],
            $data['defaultDeliveryDate'],
            $data['defaultDocumentNumberAsVariableSymbol'],
            $data['defaultConstantSymbol'],
            $data['nextInvoiceNumber'],
            $data['nextInvoiceNumberFormat']);

        $company = new Company();
        $company->setData($tabCom);
        $company->setPaymentData($tabPay);
        $company->setTemplateData($tabTmp);

        $company->setUser($user);

        $this->manager->persist($company);
        $this->manager->flush();


        $returnData = new UserCompanyCreatedReturnDataDTO($idUser, $company->getId(), $companyData, $paymentData, $templateData);


        return ($this->json($returnData));


    }


}
