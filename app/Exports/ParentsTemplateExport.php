<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ParentsTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                'Ahmed Alami',
                'ahmed.alami@parent.ma',
                'motdepasse123',
                'male',
                '+212612345678',
                '123 Avenue Hassan II, Casablanca',
                '456 Rue Mohamed V, Rabat',
                'Ingénieur',
                '+212687654321'
            ],
            [
                'Fatima Bennani',
                'fatima.bennani@parent.ma',
                'password456',
                'female',
                '+212698765432',
                '789 Boulevard Zerktouni, Casablanca',
                '321 Avenue des FAR, Casablanca',
                'Médecin',
                '+212676543210'
            ],
            [
                'Mohammed Tazi',
                'mohammed.tazi@parent.ma',
                'securepwd789',
                'male',
                '+212665432109',
                '45 Rue Allal Ben Abdellah, Rabat',
                '67 Avenue Ibn Sina, Rabat',
                'Professeur',
                '+212654321098'
            ],
            [
                'Khadija El Fassi',
                'khadija.elfassi@parent.ma',
                'password321',
                'female',
                '+212643210987',
                '12 Rue de la Liberté, Fès',
                '34 Avenue Mohammed VI, Fès',
                'Avocate',
                '+212632109876'
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
            'adresse_actuelle',
            'adresse_permanente',
            'profession',
            'contact_urgence'
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
                    'startColor' => ['argb' => 'FF3B82F6'], // Bleu
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
            'F' => 35, // adresse_actuelle
            'G' => 35, // adresse_permanente
            'H' => 20, // profession
            'I' => 15, // contact_urgence
        ];
    }
}