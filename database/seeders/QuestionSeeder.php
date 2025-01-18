<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $questions = [
            'What is your expected salary?',
            'How do you handle situations where team members are not meeting expectations?',
            'What is your greatest weakness, and how are you working to improve it?',
            'Why do you want to work for our company?',
            'What motivates you to perform well at work?',
            'Can you describe a time when you faced a challenge at work and how you resolved it?',
            'What is an achievement you are most proud of in your previous roles?',
            'Tell me about a time you made a mistake at work. How did you handle it?',
            'How do you prioritize tasks when you have tight deadlines?',
            'How do you handle working with team members who have different opinions from you?',
            'Tell me about a time you had to resolve a conflict within a team.',
            'Can you give an example of a time when you identified a problem and implemented a solution?',
            'Have you ever introduced a new idea or process at work? What was the outcome?',
            'Have you ever taken on a leadership role? What was the result?',
            'Can you describe a time when you had to delegate tasks? How did you ensure success?',
            'What strategies do you use to stay organized in a fast-paced work environment?',
            'How do you ensure the quality of your work under tight deadlines?',
            'What are your career goals for the next few years?',
            'How do you handle receiving constructive criticism?',
            'Describe a time when you had to adapt quickly to a change.',
        ];


        foreach ($questions as $question) {
            Question::create([
                'name' => $question,
            ]);
        }
    }
}
