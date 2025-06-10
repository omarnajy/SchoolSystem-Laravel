<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TeachersTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                'Ahmed Bennani',
                'ahmed.bennani@enseignant.ma',
                'motdepasse123',
                'male',
                '+212612345678',
                '1985-03-15',
                '123 Avenue Hassan II, Casablanca',
                '456 Rue Mohamed V, Rabat'
            ],
            [
                'Fatima El Amrani',
                'fatima.elamrani@enseignant.ma',
                'password456',
                'female',
                '+212687654321',
                '1990-07-22',
                '789 Boulevard Zerktouni, Casablanca',
                '321 Avenue des FAR, Casablanca'
            ],
            [
                'Mohammed Tazi',
                'mohammed.tazi@enseignant.ma',
                'securepwd789',
                'male',
                '+212698765432',
                '1982-11-10',
                '45 Rue Allal Ben Abdellah, Rabat',
                '67 Avenue Ibn Sina, Rabat'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nom',
            'email',
            'mot_de_passe',
            'genre',
            'telephone',
            'date_naissance',
            'adresse_actuelle',
            'adresse_permanente'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour les en-têtes
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => Color::COLOR_WHITE],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF059669'], // Emerald-600
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // nom
            'B' => 30, // email
            'C' => 15, // mot_de_passe
            'D' => 12, // genre
            'E' => 15, // telephone
            'F' => 15, // date_naissance
            'G' => 35, // adresse_actuelle
            'H' => 35, // adresse_permanente
            
        ];
    }
}