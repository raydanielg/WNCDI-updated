<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\MemberOrganization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default admin user (idempotent + keeps password in sync)
        User::updateOrCreate(
            ['email' => 'admin@wncdi.org'],
            [
                'name' => 'WNCDi Admin',
                'role' => 'admin',
                'password' => Hash::make('WNCDi@2026Admin'),
            ],
        );

        // Sample blog posts

        // Testimonials
        Testimonial::updateOrCreate(
            ['name' => 'Michael Gough'],
            [
                'role' => 'Logistics Director, GCC Region',
                'avatar_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gouch.png',
                'headline' => 'It was a great experience!',
                'body1' => 'Our platform connects logistics professionals, trade associations, and businesses. The events and forums make it easy to meet partners, learn about new opportunities, and build long-term relationships.',
                'body2' => 'There is absolutely no doubt in my mind that this platform has enabled us to expand our logistics network significantly.',
            ],
        );

        Testimonial::updateOrCreate(
            ['name' => 'Bonnie Green'],
            [
                'role' => 'Freight Forwarding CEO',
                'avatar_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                'headline' => 'A strong community for freight forwarders',
                'body1' => 'Through the platform we discovered new partners across regions. The system makes it simple to register, connect and follow up after events.',
                'body2' => 'Our team now has a clear view of who to work with in each corridor, which has reduced delays and improved customer satisfaction dramatically.',
            ],
        );

        Testimonial::updateOrCreate(
            ['name' => 'Lana Byrd'],
            [
                'role' => 'CTO, Logistics Technology Firm',
                'avatar_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/sofia-mcguire.png',
                'headline' => 'Digital tools that actually help operations',
                'body1' => 'The registration flows, dashboards and communication tools are very intuitive. Our logistics teams adopted them quickly.',
                'body2' => 'We now coordinate multi-country shipments with fewer mistakes, thanks to the shared platform and network.',
            ],
        );

        // Team members
        TeamMember::updateOrCreate(
            ['name' => 'Bonnie Green'],
            [
                'title' => 'CEO & Logistics Strategist',
                'bio' => "Leads the vision and partnerships connecting freight forwarders and trade leaders.",
                'photo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                'facebook_url' => '#',
                'twitter_url' => '#',
            ],
        );

        TeamMember::updateOrCreate(
            ['name' => 'Jese Leos'],
            [
                'title' => 'CTO & Digital Platforms Lead',
                'bio' => "Oversees digital tools, registrations, and member platforms.",
                'photo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png',
                'facebook_url' => '#',
                'twitter_url' => '#',
            ],
        );

        TeamMember::updateOrCreate(
            ['name' => 'Michael Gough'],
            [
                'title' => 'Partnerships & Trade Relations',
                'bio' => 'Builds relationships with freight forwarders, shippers, and government agencies.',
                'photo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gouch.png',
                'facebook_url' => '#',
                'twitter_url' => '#',
            ],
        );

        TeamMember::updateOrCreate(
            ['name' => 'Lana Byrd'],
            [
                'title' => 'Marketing & Community',
                'bio' => 'Leads outreach, events, and communication with members and partners.',
                'photo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/sofia-mcguire.png',
                'facebook_url' => '#',
                'twitter_url' => '#',
            ],
        );

        // Member organizations
        $members = [
            ['name' => 'Horse Cargo', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/horse-logo.png'],
            ['name' => 'Xerin Logistics', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/erind-logo.png'],
            ['name' => 'Twiga Star Cargo', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/flowbite-logo.png'],
            ['name' => 'Moka Cargo', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/stripe-logo.png'],
            ['name' => 'Global Express', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/mailchimp-logo.png'],
            ['name' => 'Shamirik Air Cargo', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/slack-logo.png'],
            ['name' => 'Antelope Sea Shipping', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/spotify-logo.png'],
            ['name' => 'Timeless Shipping', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/tesla-logo.png'],
            ['name' => 'Marmara Logistics', 'logo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo/netflix-logo.png'],
        ];

        foreach ($members as $member) {
            MemberOrganization::updateOrCreate(
                ['name' => $member['name']],
                ['logo_url' => $member['logo_url']],
            );
        }

        // Seed WNCDi specific content
        $this->call(WNCDiSeeder::class);
    }
}
