<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Note>
 */
class NoteFactory extends Factory
{
    protected $model = Note::class;

    private static array $titles = [
        'Complete Guide to Data Structures and Algorithms',
        'Machine Learning Fundamentals — Lecture Notes',
        'Calculus III: Multivariable Functions Explained',
        'Organic Chemistry Reaction Mechanisms Cheatsheet',
        'World War II — Causes, Events, and Aftermath',
        'Introduction to Neural Networks with Python',
        'Thermodynamics Laws — Summary & Problem Sets',
        'Literary Analysis: The Great Gatsby by Fitzgerald',
        'Computer Networks — OSI Model Deep Dive',
        'Linear Algebra: Eigenvectors and Eigenvalues',
        'Cell Biology — Mitosis vs Meiosis Comparison',
        'Database Normalization (1NF, 2NF, 3NF, BCNF)',
        'Electromagnetic Waves — Maxwell\'s Equations',
        'Macroeconomics: Keynesian vs Monetarist Theory',
        'Sorting Algorithms Complexity Analysis',
        'Shakespeare\'s Hamlet — Character Study Notes',
        'Probability & Statistics for Data Science',
        'Operating Systems — Process Scheduling Algorithms',
        'Human Anatomy: The Cardiovascular System',
        'Quantum Mechanics — Wave-Particle Duality',
        'Software Design Patterns — Gang of Four',
        'French Revolution Timeline and Key Figures',
        'Differential Equations — Solving Techniques',
        'Genetics: DNA Replication and Transcription',
        'REST API Design Best Practices',
        'Introduction to Philosophy — Epistemology Notes',
        'Climate Change — Scientific Evidence & Models',
        'Number Theory — Prime Numbers and Cryptography',
        'Photosynthesis and Cellular Respiration Comparison',
        'History of Modern Art Movements',
        'Artificial Intelligence — Search Algorithms',
        'Corporate Finance — NPV and IRR Explained',
        'Compiler Design — Lexical Analysis',
        'Psychology — Cognitive Behavioral Therapy Notes',
        'The Roman Empire — Rise and Fall',
        'Graph Theory — Dijkstra\'s Algorithm Walkthrough',
        'Environmental Science — Ecosystem Dynamics',
        'Constitutional Law — Landmark Supreme Court Cases',
        'Mathematical Proof Techniques — Induction',
        'Microbiology — Bacteria vs Viruses',
        'Supply Chain Management Fundamentals',
        'Computer Vision — Convolutional Neural Networks',
        'Music Theory — Harmony and Counterpoint',
        'Nuclear Physics — Fission and Fusion',
        'Introduction to Sociology — Social Institutions',
        'Business Strategy — Porter\'s Five Forces',
        'Discrete Mathematics — Logic and Set Theory',
        'Anatomy of the Brain — Neuroscience Notes',
        'Cloud Computing — AWS Core Services Overview',
        'Ethics in Technology — AI and Privacy',
    ];

    private static array $excerpts = [
        'These comprehensive notes cover all the key concepts you need to master this topic. I\'ve organized everything from basics to advanced topics with clear examples and diagrams.',
        'Prepared these notes while studying for finals. Includes worked examples, key formulas, and common exam questions with solutions.',
        'Detailed breakdown of the core concepts with visual explanations. Great for visual learners — includes charts, tables, and step-by-step solutions.',
        'My personal study notes compiled from textbook readings and lecture slides. Highlights the most important points you\'ll need for your exams.',
        'Complete summary with examples from real-world applications. Shows how these concepts connect to actual problems in the field.',
        'These notes helped me score top marks. Structured for efficient review — each section builds on the previous one logically.',
        'Beginner-friendly introduction with no assumed prior knowledge. Perfect if you\'re encountering this topic for the first time.',
        'Advanced deep-dive for students who already understand the basics and want to push further. Includes edge cases and tricky scenarios.',
    ];

    public function definition(): array
    {
        $title = fake()->randomElement(self::$titles);

        return [
            'user_id'     => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id,
            'title'       => $title,
            'slug'        => Str::slug($title) . '-' . fake()->unique()->numerify('####'),
            'content'     => $this->generateContent(),
            'visibility'  => fake()->randomElement(['public', 'public', 'public', 'followers', 'private']),
            'views_count' => fake()->numberBetween(0, 5000),
            'likes_count' => fake()->numberBetween(0, 500),
            'saves_count' => fake()->numberBetween(0, 300),
        ];
    }

    private function generateContent(): string
    {
        $excerpt = fake()->randomElement(self::$excerpts);
        $paragraphs = [];

        for ($i = 0; $i < fake()->numberBetween(3, 6); $i++) {
            $paragraphs[] = '<p>' . fake()->paragraph(fake()->numberBetween(3, 8)) . '</p>';
        }

        $headings = ['Introduction', 'Key Concepts', 'Core Theory', 'Examples', 'Summary', 'Practice Problems'];
        $selectedHeadings = fake()->randomElements($headings, 2);

        return '<p><strong>' . $excerpt . '</strong></p>'
            . $paragraphs[0]
            . '<h2>' . $selectedHeadings[0] . '</h2>'
            . implode('', array_slice($paragraphs, 1, 2))
            . '<h2>' . $selectedHeadings[1] . '</h2>'
            . implode('', array_slice($paragraphs, 3));
    }
}
