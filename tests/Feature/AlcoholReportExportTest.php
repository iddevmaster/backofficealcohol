<?php

use App\Exports\AlcoholReportExport;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

it('maps alcohol level of 0 to a string formatted as 0.00', function () {
    $export = new AlcoholReportExport([]);

    $row = (object) [
        'emp_id' => 'EMP001',
        'full_name' => 'John Doe',
        'department' => 'IT',
        'branch' => 'Bangkok',
        'organization' => 'HQ',
        'device_sn' => 'SN123456',
        'alcohol_level' => 0.00,
        'status' => 'ผ่าน',
        'testing_date' => '2026-05-20 10:00:00',
    ];

    $mapped = $export->map($row);

    expect($mapped[6])->toBe('0.00');
});

it('maps non-zero alcohol level to exact formatted string', function () {
    $export = new AlcoholReportExport([]);

    $row = (object) [
        'emp_id' => 'EMP001',
        'full_name' => 'John Doe',
        'department' => 'IT',
        'branch' => 'Bangkok',
        'organization' => 'HQ',
        'device_sn' => 'SN123456',
        'alcohol_level' => 0.15,
        'status' => 'ไม่ผ่าน',
        'testing_date' => '2026-05-20 10:00:00',
    ];

    $mapped = $export->map($row);

    expect($mapped[6])->toBe('0.15');
});

it('sets column formats for G as text', function () {
    $export = new AlcoholReportExport([]);
    expect($export->columnFormats())->toBe([
        'G' => '@',
    ]);
});

it('binds column G using explicit string value binder', function () {
    $export = new AlcoholReportExport([]);

    // Create a mock/stub cell for column G
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $cellG = $sheet->getCell('G1');

    $export->bindValue($cellG, '0.00');

    expect($cellG->getValue())->toBe('0.00');
    expect($cellG->getDataType())->toBe(DataType::TYPE_STRING);
});
