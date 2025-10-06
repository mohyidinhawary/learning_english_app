<?php

namespace App\Filament\Resources\ExercieseTemplates\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;


class ExercieseTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // الدرس المرتبط
                Select::make('lesson_id')
                    ->label('Lesson')
                    ->relationship('lesson', 'title')
                    ->required(),


                    Select::make('word_id')
                    ->label('word')
                    ->relationship('word', 'en_text')
                    ->required(),

                     Select::make('difficulty')
                ->label('difficulty')->options([
                    'easy'   => 'Easy',
                    'medium' => 'Medium',
                    'hard'   => 'Hard',
                ]),

                // نوع التمرين
                Select::make('type')
                    ->label('Exercise Type')
                    ->options([
                        'mcq'        => 'MCQ',
                        'translate'  => 'Translate',
                        'order'      => 'Order',
                        'listen'     => 'Listen',
                        'speak'      => 'Speak',
                        'match'      => 'Match',
                        'fill_blank' => 'Fill Blank',
                    ])
                    ->reactive()
                    ->required(),

                // نص السؤال (عام)
                Textarea::make('question')
                    ->label('Question')
                    ->rows(2),
// Textarea::make('settings.hint')
//     ->label('Hint')
//     ->rows(2)
//     ->placeholder('اكتب التلميح الذي يظهر للطالب بعد المحاولات')
//     ->visible(fn ($get) => in_array($get('type'), [
//         'mcq','translate','order','listen','speak','match','fill_blank'
//     ])),



                // الحالة
                Select::make('status')
                    ->label('status')
                    ->options([
                        'draft'    => 'Draft',
                        'active'   => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('draft'),

                // MCQ → خيارات متعددة
                Repeater::make('options')
                    ->relationship('options')
                    ->schema([
                        TextInput::make('value')->label('Option')->required(),
                        Toggle::make('is_correct')->label('Correct')->default(false),
                    ])

                    ->columns(2)
                    ->visible(fn ($get) => in_array($get('type'), ['mcq', 'listen','translate','order','match'])),

                // Translate → نص إنكليزي + نص عربي
                // TextInput::make('settings.en_text')
                //     ->label('English Text')
                //     ->visible(fn ($get) => $get('type') === 'translate'),
                // TextInput::make('settings.ar_text')
                //     ->label('Arabic Text')
                //     ->visible(fn ($get) => $get('type') === 'translate'),

                // Order → كلمات داخل Repeater
                Repeater::make('settings.items')
                    ->schema([
                        TextInput::make('word')->label('Word'),
                    ])
                    ->columns(1)
                    ->visible(fn ($get) => $get('type') === 'order'),

                // Listen → رفع ملف صوت
                FileUpload::make('settings.audio_url')
                    ->label('Audio File')
                    ->acceptedFileTypes(['audio/*'])
                    ->directory('exercises/audio')
                    ->visible(fn ($get) => in_array($get('type'), ['listen','order','mcq'])),

                // Speak → prompt نصي
                Textarea::make('settings.prompt')
                    ->label('Prompt')
                    ->rows(2)
                    ->visible(fn ($get) => $get('type') === 'speak'),

                // Match → أزواج (يسار/يمين)
                Repeater::make('settings.pairs')
                    ->schema([
                        TextInput::make('left')->label('Left'),
                        TextInput::make('right')->label('Right'),
                        FileUpload::make('right_audio')
            ->label('Right (Audio)')
            ->acceptedFileTypes(['audio/*'])
            ->directory('exercises/audio'),

        // يمين (صورة)
        FileUpload::make('right_image')
            ->label('Right (Image)')
            ->image()
            ->directory('exercises/images'),
                    ])
                    ->columns(2)
                    ->visible(fn ($get) => $get('type') === 'match'),

                // Fill Blank → جملة + الجواب الصحيح
                Textarea::make('settings.sentence')
                    ->label('Sentence (use ___ for blank)')
                    ->rows(2)
                    ->visible(fn ($get) => $get('type') === 'fill_blank'),
                TextInput::make('settings.correct_answer')
                    ->label('Correct Answer')
                    ->visible(fn ($get) => $get('type') === 'fill_blank'),

Repeater::make('settings.hints')
    ->label('Hints')
    ->schema([
        Textarea::make('text')
            ->label('Hint Text')
            ->rows(2)
            ->required(),
    ])
    ->visible(fn ($get) => in_array($get('type'), [
        'translate', 'fill_blank', 'match', 'listen', 'speak',"order"
    ])),

// Order → التلميحات من نفس الكلمات (items) → Already موجودة
// Repeater::make('settings.items')
//     ->schema([
//         TextInput::make('word')->label('Word'),
//     ])
//     ->columns(1)
//     ->visible(fn ($get) => $get('type') === 'order'),


            ]);
    }
}
