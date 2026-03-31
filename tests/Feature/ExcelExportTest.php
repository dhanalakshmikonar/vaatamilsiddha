<?php

namespace Tests\Feature;

use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PatientMedicine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ZipArchive;

class ExcelExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_patients_export_downloads_a_real_xlsx_file(): void
    {
        $this->actingAs(User::factory()->create());

        $medicine = Medicine::create([
            'name' => 'Ashwagandha',
            'mode_of_product' => 'Tablet',
            'pharmaceutical_name' => 'Herbal Labs',
            'expiry_date' => '2027-12-31',
            'cost_price' => 100,
            'selling_price' => 120,
            'total_amount' => 1200,
            'cost' => 100,
            'stock' => 10,
        ]);

        $patient = Patient::create([
            'name' => 'Ravi',
            'age' => 35,
            'gender' => 'Male',
            'phone' => '9999999999',
            'place' => 'Chennai',
            'entity' => 'Walk-in',
            'payment_mode' => 'Cash',
            'fees' => 200,
            'visit_date' => '2026-03-31',
            'diagnosis' => 'Cold',
            'total_amount' => 320,
        ]);

        PatientMedicine::create([
            'patient_id' => $patient->id,
            'medicine_id' => $medicine->id,
            'quantity' => 1,
            'unit_price' => 120,
            'total_price' => 120,
        ]);

        $response = $this->get('/patients/export');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->assertStringContainsString('.xlsx', $response->headers->get('content-disposition', ''));

        $xlsx = $response->streamedContent();
        $worksheetXml = $this->extractZipEntry($xlsx, 'xl/worksheets/sheet1.xml');
        $workbookXml = $this->extractZipEntry($xlsx, 'xl/workbook.xml');

        $this->assertStringContainsString('Patients', $workbookXml);
        $this->assertStringContainsString('Name', $worksheetXml);
        $this->assertStringContainsString('Ravi', $worksheetXml);
        $this->assertStringContainsString('Ashwagandha x 1', $worksheetXml);
    }

    public function test_medicines_export_downloads_a_real_xlsx_file(): void
    {
        $this->actingAs(User::factory()->create());

        Medicine::create([
            'name' => 'Nilavembu',
            'mode_of_product' => 'Syrup',
            'pharmaceutical_name' => 'Clinic Pharma',
            'expiry_date' => '2026-10-01',
            'cost_price' => 80,
            'selling_price' => 96,
            'total_amount' => 960,
            'cost' => 80,
            'stock' => 12,
        ]);

        $response = $this->get('/medicines/export');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $worksheetXml = $this->extractZipEntry($response->streamedContent(), 'xl/worksheets/sheet1.xml');

        $this->assertStringContainsString('Mode of Product', $worksheetXml);
        $this->assertStringContainsString('Nilavembu', $worksheetXml);
        $this->assertStringContainsString('Clinic Pharma', $worksheetXml);
    }

    public function test_billing_export_downloads_a_real_xlsx_file(): void
    {
        $this->actingAs(User::factory()->create());

        $medicine = Medicine::create([
            'name' => 'Brahmi',
            'mode_of_product' => 'Powder',
            'pharmaceutical_name' => 'Siddha Care',
            'expiry_date' => '2027-01-01',
            'cost_price' => 50,
            'selling_price' => 60,
            'total_amount' => 600,
            'cost' => 50,
            'stock' => 20,
        ]);

        $patient = Patient::create([
            'name' => 'Meena',
            'age' => 29,
            'gender' => 'Female',
            'phone' => '8888888888',
            'place' => 'Madurai',
            'entity' => 'Referral',
            'payment_mode' => 'UPI',
            'fees' => 150,
            'visit_date' => '2026-03-31',
            'diagnosis' => 'Fever',
            'total_amount' => 210,
        ]);

        PatientMedicine::create([
            'patient_id' => $patient->id,
            'medicine_id' => $medicine->id,
            'quantity' => 1,
            'unit_price' => 60,
            'total_price' => 60,
        ]);

        $response = $this->get('/billing/export');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $worksheetXml = $this->extractZipEntry($response->streamedContent(), 'xl/worksheets/sheet1.xml');

        $this->assertStringContainsString('Bill Items', $worksheetXml);
        $this->assertStringContainsString('Meena', $worksheetXml);
        $this->assertStringContainsString('Consultation / Fees', $worksheetXml);
        $this->assertStringContainsString('Brahmi x 1', $worksheetXml);
    }

    private function extractZipEntry(string $xlsxBinary, string $entry): string
    {
        $path = tempnam(sys_get_temp_dir(), 'test_xlsx_');
        file_put_contents($path, $xlsxBinary);

        $zip = new ZipArchive();
        $zip->open($path);
        $contents = $zip->getFromName($entry);
        $zip->close();
        @unlink($path);

        $this->assertNotFalse($contents, 'Expected ZIP entry was not found: ' . $entry);

        return (string) $contents;
    }
}
