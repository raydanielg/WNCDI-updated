<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Objective;
use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class WNCDiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed General Settings with WNCDi Information
        GeneralSetting::updateOrCreate(
            ['id' => 1],
            [
                'organization_name' => 'Without Non Communicable Diseases Initiative',
                'site_name' => 'WNCDi',
                'organization_description' => 'A youth-led Non-Governmental, non-profit, non-political, non-religious organization registered by Tanzania ministry of Community Development, Gender, Elderly and Children (MCDGEC) with registration number 00NGO/R/7809 under NGO Act No. 24 of 2002.',
                'tagline' => 'Becoming Healthier Together',
                'vision' => 'To create the society that is free from preventable Non-Communicable diseases burden, aware of health determinants to Non-communicable Diseases with Younger Generation actively involved.',
                'mission' => 'Provision of incessant advocacy, campaigns and education on Non communicable diseases with their risk factors proportionally to the need of early diagnosis and effective NCDs control.',
                'about_text' => 'Without Non Communicable Diseases Initiative (WNCDi) is a youth-led Non-Governmental, non-profit, non-political, non-religious organization registered in December 2024 by Tanzania Ministry of Community Development, Gender, Elderly and Children (MCDGEC) with registration number 00NGO/R/7809 under NGO Act No. 24 of 2002. WNCDi has the main objective of rising awareness to the community on various Non Communicable Diseases and emphasis on good approaches to get rid of Non Communicable Diseases (NCDs) burden which is currently accountable for more than 70% of life loss globally. Over 70% of all deaths globally are due to Non-Communicable Diseases (NCDs) where 41 - 44% of deaths in Tanzania are attributed to NCDs according to WHO estimates.',
                'registration_number' => '00NGO/R/7809',
                'founding_year' => '2024',
                'bank_name' => 'National Bank of Commerce',
                'bank_account' => '041172000179',
                'bank_account_name' => 'WITHOUT NON COMMUNICABLE DISEASES INITIATIVE (WNCDi)',
                'primary_phone' => '+255621068500',
                'secondary_phone' => '+255625710549',
                'primary_email' => 'wncdinitiative@gmail.com',
                'facebook_url' => 'https://facebook.com/Wncd Initiative',
                'twitter_url' => 'https://twitter.com/WNCD_Initiative',
                'instagram_url' => 'https://instagram.com/wncd_initiative',
                'linkedin_url' => 'https://linkedin.com/company/wncd-initiative',
            ]
        );

        // Seed Programs/Activities
        $programs = [
            [
                'name' => 'NCDs Advocacy',
                'short_description' => 'Community and online education on different NCDs',
                'description' => 'As the main objective of WNCDi, we have a continuous program of educating the society in both onsite and online on different NCDs including good approach the society can adapt to avoid fall into preventable NCDs. Through our community reaching activities we emphasize on adoption of Healthier life styles like maintaining physical activeness, healthy diet consideration, frequent NCDs checkups and effective management to the ones who already have any of the NCD.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Creation of younger NCDs champions',
                'short_description' => 'Health mentorship and school NCDs education through health clubs',
                'description' => 'We believe in the power of youth awareness to create the future healthy community. We have the health mentorship and lower level schools NCDs education to very younger generation in primary and secondary schools through the NCDs health clubs established. We have already younger NCDs ambassadors in lower level schools in Dar Es Salaam.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Health determinants campaigns',
                'short_description' => 'NCDs fight campaigns emphasizing community responsibility and healthy lifestyles',
                'description' => 'We have the NCDs fight health campaigns that emphasize and reminds the community on their responsibility to protect themselves from the preventable NCDs.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'International NCDs Commemorations',
                'short_description' => 'Participation in global NCD awareness days with education and prevention tips',
                'description' => 'To let the continuous education, we join the world\'s different NCD commemorations by implementing some activities which are associated with provision of education with important tips that society need to know about that specific disease. The provisions are associated with proper ways to adapt and avoid falling into getting the disease.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Collaborative NCDs screening',
                'short_description' => 'Community health screening camps with education delivery sessions',
                'description' => 'To help the community members know their NCDs health status, we plan and organize collaborative screening camps to the community areas and help the society check the basic NCDs such as blood glucose level tests, blood pressure, Body Mass Index, cancer marker tests and other vital tests. The screening camps are associated with NCDs education delivery sessions and management educations that is provided by the doctors and trained WNCDi team. The education part in screening are also moving together with the provision of healthier lifestyles to adapt for avoidance of preventable NCDs.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Partnership',
                'short_description' => 'Collaboration with institutions and organizations fighting against NCDs',
                'description' => 'We also partner with other institutions, organizations, associations and even companies that have the aim target of help the fight against NCDs to the community. The partnership window and collaboration is open to anyone with the typical aim of helping rise NCDs awareness to the society and target of preventing them. We are also in a ready-line to partner with governmental and international institution that will gear the community health development by material and financial Support.',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($programs as $program) {
            Program::updateOrCreate(
                ['slug' => \Str::slug($program['name'])],
                $program
            );
        }

        // Seed Objectives
        $objectives = [
            [
                'number' => 1,
                'title' => 'Attaining effective health promotion and preventive strategies',
                'description' => 'Attaining effective health promotion and preventive strategies that address individual behaviors due to life styles and emphasize best healthy choices',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'number' => 2,
                'title' => 'Provision of substantive knowledge to the society',
                'description' => 'Provision of substantive knowledge to the society on the major determinants underlying NCDs occurrence and progression',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'number' => 3,
                'title' => 'Furnishing advocacy on the five burning NCDs trends in Tanzania',
                'description' => 'Furnishing advocacy on the five burning NCDs trends in Tanzania (i.e Cardiovascular Diseases, Diabetes, Cancer, Chronic respiratory diseases also mental health)',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'number' => 4,
                'title' => 'Establishment and organization of Health determinants campaigns',
                'description' => 'Establishment and organization of Health determinants campaigns that will assist attainment of WHO Sustainable Development Goal 3.4 by 2030',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'number' => 5,
                'title' => 'Inviting various health professionals and NCDs experts',
                'description' => 'Inviting various health professionals and NCDs experts from different health facilities and academic fields to share their experience on more ways of escaping from NCD burden and the effective control programs.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'number' => 6,
                'title' => 'Operating in partnership with local and international organizations',
                'description' => 'To operate in complementarity, collaboration and partnership with local and international organizations or associations which have the common goals of addressing and fighting against NCD burden.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'number' => 7,
                'title' => 'Encouraging health promotion and NCD prevention through screening',
                'description' => 'Encouraging health promotion and NCD prevention through organization of collaborative community NCDs screening camps while educating the society on the necessity of early disease detection',
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($objectives as $objective) {
            Objective::updateOrCreate(
                ['number' => $objective['number']],
                $objective
            );
        }
    }
}
