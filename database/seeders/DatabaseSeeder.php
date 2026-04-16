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
        Post::updateOrCreate(
            ['slug' => 'online-registration-open-tanford-forum-dubai-2025'],
            [
                'title' => 'Online Registration Now Open for Tanzania Global Trade & Logistics Forum 2025 in Dubai',
                'category' => 'Announcements',
                'author_name' => 'Admin',
                'image_url' => '/images/DXB_3576-1536x1024.jpg',
                'excerpt' => 'Online registration is now open for participants and exhibitors ahead of the Tanzania Global Trade & Logistics Forum 2025 in Dubai.',
                'body' => 'The organizing committee of the Tanzania Global Trade & Logistics Forum 2025 has officially announced that online registration is now open for participants and exhibitors ahead of the highly anticipated event, scheduled to take place on 13th–14th February 2026, at the iconic Shangri-La Hotel in Dubai.' . "\n\n" .
                    'Hosted by TANFORD (Tanzania Freight Forwarders Association) under the theme "Connecting Global Trade to Africa\'s Heart," the forum is expected to attract delegates from Africa, the Middle East, Asia, and Europe.',
                'published_at' => now(),
            ],
        );

        Post::updateOrCreate(
            ['slug' => 'new-members-window-open-join-tanford'],
            [
                'title' => 'Window Now Open for New Members to Join TANFORD — Uniting Tanzanians in the Global Logistics Arena',
                'category' => 'Membership',
                'author_name' => 'Admin',
                'image_url' => '/images/Tanford-PX1.jpeg',
                'excerpt' => 'TANFORD has opened its doors for new members to join its growing community of logistics and freight professionals.',
                'body' => 'The Tanzania Freight Forwarders Association (TANFORD) has officially opened its doors for new members to join its growing community of logistics and freight forwarding professionals.' . "\n\n" .
                    'Through this membership window, Tanzanian companies and professionals operating locally or abroad can connect, learn, and collaborate on key trade and logistics opportunities.',
                'published_at' => now()->subDays(3),
            ],
        );

        Post::updateOrCreate(
            ['slug' => 'tanford-hosts-global-trade-logistics-forum-dubai-2026'],
            [
                'title' => 'TANFORD to Host Tanzania Global Trade & Logistics Forum 2025 in Dubai in February 2026',
                'category' => 'Events',
                'author_name' => 'Admin',
                'image_url' => '/images/DXB_3883-1536x1024.jpg',
                'excerpt' => 'TANFORD is proud to host the Tanzania Global Trade & Logistics Forum 2025, bringing together key players in regional and global trade.',
                'body' => 'TANFORD is proud to announce the hosting of the Tanzania Global Trade & Logistics Forum 2025, a flagship event designed to position Tanzania as a strategic trade and logistics hub for Africa.' . "\n\n" .
                    'The forum will feature high-level discussions, exhibitions, and B2B sessions focused on infrastructure, ports, customs, and trade facilitation.',
                'published_at' => now()->subWeek(),
            ],
        );

        // Testimonials
        Testimonial::updateOrCreate(
            ['name' => 'Michael Gough'],
            [
                'role' => 'Logistics Director, GCC Region',
                'avatar_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gouch.png',
                'headline' => 'It was a great experience!',
                'body1' => 'Tanford connects logistics professionals, trade associations, and businesses across Tanzania and the GCC region. The events and forums make it easy to meet partners, learn about new opportunities, and build long-term relationships.',
                'body2' => 'There is absolutely no doubt in my mind that without Tanford, I would not have been able to expand my logistics network this quickly.',
            ],
        );

        Testimonial::updateOrCreate(
            ['name' => 'Bonnie Green'],
            [
                'role' => 'Freight Forwarding CEO',
                'avatar_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                'headline' => 'A strong community for freight forwarders',
                'body1' => 'Through Tanford we discovered new partners in Dubai and Dar es Salaam. The platform makes it simple to register, connect and follow up after events.',
                'body2' => 'Our team now has a clear view of who to work with in each corridor, which has reduced delays and improved customer satisfaction dramatically.',
            ],
        );

        Testimonial::updateOrCreate(
            ['name' => 'Lana Byrd'],
            [
                'role' => 'CTO, Logistics Technology Firm',
                'avatar_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/sofia-mcguire.png',
                'headline' => 'Digital tools that actually help operations',
                'body1' => 'The registration flows, dashboards and communication tools that Tanford provides are very intuitive. Our logistics teams adopted them quickly.',
                'body2' => 'We now coordinate multi-country shipments with fewer mistakes, thanks to the shared platform and network that Tanford offers.',
            ],
        );

        // Team members
        TeamMember::updateOrCreate(
            ['name' => 'Bonnie Green'],
            [
                'title' => 'CEO & Logistics Strategist',
                'bio' => "Leads TANFORD's vision and partnerships connecting freight forwarders and trade leaders.",
                'photo_url' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                'facebook_url' => '#',
                'twitter_url' => '#',
            ],
        );

        TeamMember::updateOrCreate(
            ['name' => 'Jese Leos'],
            [
                'title' => 'CTO & Digital Platforms Lead',
                'bio' => "Oversees TANFORD's digital tools, registrations, and member platforms.",
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
                'bio' => 'Leads outreach, events, and communication with TANFORD members and partners.',
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
