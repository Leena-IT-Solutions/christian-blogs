<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
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
        // 1. Create Admin User
        $admin = User::create([
            'name' => 'Sheeba',
            'email' => 'admin@berootedinchrist.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Create Categories
        $devotionals = \App\Models\Category::create([
            'name' => 'Daily Devotionals',
            'slug' => 'daily-devotionals',
            'description' => 'Short daily reflections and scriptures to encourage your faith.',
        ]);

        $studies = \App\Models\Category::create([
            'name' => 'Scripture Studies',
            'slug' => 'scripture-studies',
            'description' => 'In-depth textual analysis and theological studies of the Bible.',
        ]);

        $christianLife = \App\Models\Category::create([
            'name' => 'Faith & Christian Life',
            'slug' => 'faith-christian-life',
            'description' => 'Practical guides and articles about living out Christian values.',
        ]);

        // 3. Create Tags
        $grace = \App\Models\Tag::create(['name' => 'Grace', 'slug' => 'grace']);
        $prayer = \App\Models\Tag::create(['name' => 'Prayer', 'slug' => 'prayer']);
        $growth = \App\Models\Tag::create(['name' => 'Spiritual Growth', 'slug' => 'spiritual-growth']);
        $bible = \App\Models\Tag::create(['name' => 'Bible Study', 'slug' => 'bible-study']);
        $faith = \App\Models\Tag::create(['name' => 'Faith', 'slug' => 'faith']);

        // 4. Create Settings
        \App\Models\Setting::create([
            'key' => 'site_title',
            'value' => 'Be Rooted in Christ'
        ]);
        \App\Models\Setting::create([
            'key' => 'site_subtitle',
            'value' => 'Planted to Prevail & Produce'
        ]);
        \App\Models\Setting::create([
            'key' => 'about_text',
            'value' => "Welcome to **Be Rooted in Christ**. 

This blog is dedicated to sharing spiritual insights, deep scripture studies, and daily devotionals to help believers grow in their faith, stand firm under trials, and produce abundant fruit for the glory of God.

*\"Abide in me, and I in you. As the branch cannot bear fruit of itself, except it abide in the vine; no more can ye, except ye abide in me. I am the vine, ye are the branches: He that abideth in me, and I in him, the same bringeth forth much fruit: for without me ye can do nothing.\"* — **John 15:4-5**"
        ]);
        \App\Models\Setting::create([
            'key' => 'about_image',
            'value' => ''
        ]);
        \App\Models\Setting::create([
            'key' => 'site_logo',
            'value' => ''
        ]);
        \App\Models\Setting::create([
            'key' => 'site_favicon',
            'value' => ''
        ]);
        \App\Models\Setting::create([
            'key' => 'use_logo_as_favicon',
            'value' => '0'
        ]);
        \App\Models\Setting::create([
            'key' => 'facebook_link',
            'value' => 'https://facebook.com'
        ]);
        \App\Models\Setting::create([
            'key' => 'instagram_link',
            'value' => 'https://instagram.com'
        ]);
        \App\Models\Setting::create([
            'key' => 'twitter_link',
            'value' => ''
        ]);
        \App\Models\Setting::create([
            'key' => 'youtube_link',
            'value' => ''
        ]);
        \App\Models\Setting::create([
            'key' => 'pinterest_link',
            'value' => ''
        ]);
        \App\Models\Setting::create([
            'key' => 'hero_title',
            'value' => 'Planted to Prevail'
        ]);
        \App\Models\Setting::create([
            'key' => 'hero_subtitle',
            'value' => 'Sowing seeds of Truth, nurturing roots of faith, and bearing fruit for the glory of Christ.'
        ]);
        \App\Models\Setting::create([
            'key' => 'theme_color',
            'value' => '#bf9f5a'
        ]);
        \App\Models\Setting::create([
            'key' => 'footer_quote_text',
            'value' => 'As ye have therefore received Christ Jesus the Lord, so walk ye in him: Rooted and built up in him, and stablished in the faith...'
        ]);
        \App\Models\Setting::create([
            'key' => 'footer_quote_author',
            'value' => 'Colossians 2:6-7'
        ]);

        // 5. Create Posts
        $post1 = Post::create([
            'user_id' => $admin->id,
            'category_id' => $devotionals->id,
            'title' => 'A Grain of Wheat: The Path of Self-Surrender',
            'slug' => 'a-grain-of-wheat-the-path-of-self-surrender',
            'excerpt' => 'Understanding Jesus\' teaching on self-surrender, death to self, and the secret of spiritual multiplication.',
            'body' => "## The Secret of the Kernel

In John 12:24, Jesus shares a profound spiritual law: 

> \"Verily, verily, I say unto you, Except a corn of wheat fall into the ground and die, it abideth alone: but if it die, it bringeth forth much fruit.\"

At first glance, death seems like the end. A kernel of wheat kept safe in a barn remains clean, dry, and protected. But it is alone. It can never fulfill its potential. It is only when it is cast into the dark soil, hidden from sight, and undergoes disintegration that the outer shell breaks, allowing the life within to spring forth.

### Dying to Self

In our modern culture, self-preservation and self-promotion are highly valued. Yet, Christ calls us to a different path:
1. **Surrender of Control:** Letting go of our plans to receive His better plan.
2. **Death to Ambition:** Exchanging our selfish ambitions for His kingdom purposes.
3. **Trust in the Dark:** Believing that even when we feel buried, God is planting us.

### The Harvest of Surrender

When we submit to this process, God produces a rich harvest through us. We grow deeper roots, stand firmer in storms, and bring forth fruits of:
*   *Love, joy, and peace* in our interactions.
*   *Encouragement and hope* to those around us.
*   *Faithful witness* that draws others to Christ.

Let us ask ourselves today: *Are we keeping our kernels safe in the barn, or are we willing to let God plant us in the ground?*",
            'status' => 'published',
            'published_at' => now()->subDays(3),
        ]);
        $post1->tags()->sync([$growth->id, $faith->id]);
    }
}
