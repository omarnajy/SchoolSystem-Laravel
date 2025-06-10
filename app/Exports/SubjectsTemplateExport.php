<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SubjectsTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                'Mathématiques',
                '101',
                'Cours de mathématiques générales couvrant l\'algèbre, la géométrie et les statistiques de base',
                'ahmed.bennani@enseignant.ma',
                'fatima.elamrani@enseignant.ma,mohammed.tazi@enseignant.ma'
            ],
            [
                'Physique',
                '102',
                'Cours de physique fondamentale incluant la mécanique, l\'électricité et l\'optique',
                'fatima.elamrani@enseignant.ma',
                'ahmed.bennani@enseignant.ma'
            ],
            [
                'Français',
                '201',
                'Cours de français : grammaire, littérature, expression écrite et orale',
                'mohammed.tazi@enseignant.ma',
                ''
            ],
            [
                'Anglais',
                '202',
                'Cours d\'anglais : compréhension, expression, grammaire et vocabulaire',
                'ahmed.bennani@enseignant.ma',
                'fatima.elamrani@enseignant.ma'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nom',
            'code_matiere',
            'description',
            'email_enseignant',
            'emails_enseignants_additionnels'
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
                    'startColor' => ['argb' => 'FFFF8C00'], // Orange foncé
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // nom
            'B' => 15, // code_matiere
            'C' => 60, // description
            'D' => 30, // email_enseignant
            'E' => 50, // emails_enseignants_additionnels
        ];
    }
}