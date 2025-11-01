<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'question' => 'What is the capital of France?',
                'option_a' => 'Paris',
                'option_b' => 'London',
                'option_c' => 'Berlin',
                'option_d' => 'Madrid',
                'correct_option' => 'A',
            ],
            [
                'question' => 'Which language is primarily used for web development?',
                'option_a' => 'Python',
                'option_b' => 'JavaScript',
                'option_c' => 'C++',
                'option_d' => 'Java',
                'correct_option' => 'B',
            ],
            [
                'question' => 'What does HTML stand for?',
                'option_a' => 'Hyper Text Markup Language',
                'option_b' => 'High Text Machine Language',
                'option_c' => 'Hyperlink and Text Markup Language',
                'option_d' => 'Home Tool Markup Language',
                'correct_option' => 'A',
            ],
            [
                'question' => 'Which planet is known as the Red Planet?',
                'option_a' => 'Earth',
                'option_b' => 'Mars',
                'option_c' => 'Jupiter',
                'option_d' => 'Venus',
                'correct_option' => 'B',
            ],
            [
                'question' => 'What is 10 + 15?',
                'option_a' => '20',
                'option_b' => '25',
                'option_c' => '30',
                'option_d' => '35',
                'correct_option' => 'B',
            ],
            [
                'question' => 'Which company developed the PHP language?',
                'option_a' => 'Microsoft',
                'option_b' => 'Google',
                'option_c' => 'Rasmus Lerdorf',
                'option_d' => 'Facebook',
                'correct_option' => 'C',
            ],
            [
                'question' => 'Which of the following is a CSS framework?',
                'option_a' => 'Laravel',
                'option_b' => 'Bootstrap',
                'option_c' => 'Django',
                'option_d' => 'React',
                'correct_option' => 'B',
            ],
            [
                'question' => 'What does SQL stand for?',
                'option_a' => 'Structured Query Language',
                'option_b' => 'Simple Query Language',
                'option_c' => 'Structured Question Language',
                'option_d' => 'Standard Query Logic',
                'correct_option' => 'A',
            ],
            [
                'question' => 'Which HTML tag is used to define a paragraph?',
                'option_a' => '<head>',
                'option_b' => '<p>',
                'option_c' => '<div>',
                'option_d' => '<span>',
                'correct_option' => 'B',
            ],
            [
                'question' => 'Which data type is used to store true/false values?',
                'option_a' => 'Integer',
                'option_b' => 'String',
                'option_c' => 'Boolean',
                'option_d' => 'Array',
                'correct_option' => 'C',
            ],
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
