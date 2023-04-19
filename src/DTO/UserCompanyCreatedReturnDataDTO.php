<?php


namespace App\DTO;

class UserCompanyCreatedReturnDataDTO
{
    public string $type = 'UserCompanyCreatedReturnDataDTO';

    public int $userId;

    public int $companyId;

    public CompanyDataDTO $companyData;

    public CompanyPaymentDataDTO $companyPaymentData;

    public CompanyTemplateDataDTO $companyTemplateData;

    public function __construct(int $userId, int $companyId, CompanyDataDTO $companyData,
                                CompanyPaymentDataDTO $companyPaymentData, CompanyTemplateDataDTO $companyTemplateData)
    {
        $this->userId = $userId;
        $this->companyId = $companyId;
        $this->companyData = $companyData;
        $this->companyPaymentData = $companyPaymentData;
        $this->companyTemplateData = $companyTemplateData;
    }
}
