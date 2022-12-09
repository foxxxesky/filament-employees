<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Register;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RegisterResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegisterResource\RelationManagers;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class RegisterResource extends Resource
{
    protected static ?string $model = Register::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $options = [
            'show' => 'Ya',
            'hide' => 'Tidak',
        ];
        return $form
            ->schema([
                Section::make('Founder')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')->label('Nama Lengkap')->required(),
                                TextInput::make('position')->label('Jabatan')->required(),
                                TextInput::make('email')->label('Email')->required(),
                                TextInput::make('phone')->label('Kontak (No. WA)')->required(),
                                TextInput::make('linkedin')->label('Linkedin')->required(),
                                Select::make('commitmen')->label('Komitment')->required()->placeholder('Pilih')
                                    ->options([
                                        'fulltime' => 'Full-Time',
                                        'parttime' => 'Part-Time',
                                    ]),
                                TextInput::make('linkedin2')->label('Linkedin Founder Lainnya'),
                                TextInput::make('linkedin3')->label('Linkedin Founder Lainnya'),
                            ])
                    ]),
                Section::make('Startup')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('startup_name')->label('Nama Startup')->required(),
                                TextInput::make('founded')->label('Tahun berdiri startup')->required(),
                                TextInput::make('city')->label('Lokasi Startup')->required(),
                                TextInput::make('website')->label('Situs Resmi Startup'),
                            ]),
                        Textarea::make('desc')->label('Deskripsi startup')->rows(5)->required(),
                        Grid::make(2)
                            ->schema([
                                Select::make('startup_category')->label('Kategori')->required()->placeholder('Pilih')
                                    ->options([
                                        'Tourism' => 'Tourism',
                                        'Health' => 'Health',
                                        'Fishery' => 'Fishery',
                                        'Agriculture' => 'Agriculture'
                                    ]),
                                Select::make('company_status')->label('Status Perusahaan')->required()->placeholder('Pilih')
                                    ->options([
                                        'CV' => 'CV',
                                        'PT' => 'PT',
                                        'unknown' => 'Belum Terdaftar'
                                    ]),
                            ]),

                    ]),
                Section::make('Problem')
                    ->schema([
                        Textarea::make('problem')->label('Deskripsikan problem apa yang ingin disolusikan')->rows(5)->required(),
                        Textarea::make('problem_experience')->label('Apakah Anda mengalami problem tersebut sendiri?')->rows(5)->required(),
                        Textarea::make('problem_solve')->label('Mengapa kalian sangat ingin untuk mensolusikan permasalahan tersebut')->rows(5)->required(),
                        Textarea::make('problem_early_adopter')->label('Siapakah early adopters yang mengalami problem tersebut, deskripsikan personanya?')->rows(5)->required(),
                        Textarea::make('problem_early_adopter_location')->label('Lokasi early adopters yang mengalami problem tersebut ')->rows(5)->required(),
                        Select::make('problem_often_feel')->label('Seberapa sering problem itu dirasakan oleh early adopters')->required()->placeholder('Pilih')
                            ->options([
                                'Harian' => 'Harian',
                                'Mingguan' => 'Mingguan',
                                'Bulanan' => 'Bulanan',
                                'Tahunan' => 'Tahunan'
                            ]),
                        Textarea::make('problem_intense')->label('Seberapa intense dampak dari problem yang dirasakan oleh early adopters')->rows(5)->required(),
                    ]),
                Section::make('Solution')
                    ->schema([
                        Textarea::make('solution')->label('Apa solusi yang Anda tawarkan?')->rows(5)->required(),
                        Select::make('solution_exist')->label('Apakah solusi yang anda tawarkan sudah ada di pasaran atau ada solusi sejenis?')
                            ->options($options)
                            ->reactive()
                            ->required(),
                        Textarea::make('solution_yes')->label('Jika sudah ada, apakah solusi atau perbaikan dari journey customer yang anda solusikan dengan produk ini?')->rows(5)
                            ->visible(fn ($get) => $get('solution_exist') == 'show'),
                        Textarea::make('solution_no')->label('Jika belum apakah marketnya ada?')->rows(5)
                            ->visible(fn ($get) => $get('solution_exist') == 'hide' | $get('solution_exist') == ''),
                        Textarea::make('solution_unique')->label('Apa yang membuat solusi anda tidak dapat di duplikasi oleh startup lainnya?')->rows(5)->required(),
                        Textarea::make('solution_user')->label('Deskripsikan penggunaan usecase MVP Anda (Siapa Usernya)')->rows(5)->required(),
                        Textarea::make('solution_feature')->label('Apa saja fitur / fungsi yang digunakan')->rows(5)->required(),
                        CheckboxList::make('solution_tech')->label('Advance technology yang digunakan?')->hint('Anda dapat memilih lebih dari satu teknologi')->hintColor('primary')
                            ->options([
                                'Machine Learning (ML)' => 'Machine Learning (ML)',
                                'Internet of things (IoT)' => 'Internet of things (IoT)',
                                'Artificial Intelligence (AI)' => 'Artificial Intelligence (AI)',
                                'Augmented Reality (AR) / Virtual Reality (VR)' => 'Augmented Reality (AR) / Virtual Reality (VR)',
                                'secureCoding' => 'Machine Learning (ML)',
                                'Machine Learning (ML)' => 'Machine Learning (ML)',
                                'Others' => 'Others',
                            ]),
                        Textarea::make('solution_tech_function')->label('Jelaskan fungsi teknologi tersebut di produk Anda')->rows(5),
                        Section::make('Kami ingin mencoba produk Anda. Mohon submit akun demo produk Anda')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('solution_link')->label('Link Produk')->helperText('contoh: https://indigo.id (disertai http)'),
                                        TextInput::make('solution_account')->label('Akun demo login Jika ada')->helperText('Email / username akun demo'),
                                        TextInput::make('solution_password')->label('Password Akun')->helperText('Password akun demo'),
                                    ])
                            ]),
                    ]),
                Section::make('Traction')
                    ->schema([
                        Select::make('traction_active_user')->required()->options($options)->required()->reactive(),
                        Select::make('traction_market')->label('Segmentasi dari market yang produk anda solusikan')
                            ->options([
                                'B2B' => 'B2B',
                                'B2C' => 'B2C',
                                'B2B2C' => 'B2B2C',
                                'B2G' => 'B2G',
                                'Others' => 'Others',
                            ])
                            ->visible(fn ($get) => $get('traction_active_user') == 'show'),
                        Textarea::make('traction_customer')->label('List customer eksiting yang sudah merasa tersolusikan problemnya oleh solusi yang produk anda berikan? 3-5 customer dan berikan alasannya?')->rows(5)
                            ->visible(fn ($get) => $get('traction_active_user') == 'show'),
                        Textarea::make('traction_matric_primary')->label('Apakah primary metric dari produk anda?')->rows(5)
                            ->visible(fn ($get) => $get('traction_active_user') == 'show'),
                        Textarea::make('traction_matric_reason')->label('jelaskan mengapa menjadi primary metric')->rows(5)
                            ->visible(fn ($get) => $get('traction_active_user') == 'show'),
                        Section::make('Update primary metric dalam 6 bulan terakhir: ')
                            ->schema([
                                Textarea::make('traction_pm1')->label('Juli 2022')->rows(5),
                                Textarea::make('traction_pm2')->label('Agustus 2022')->rows(5),
                                Textarea::make('traction_pm3')->label('September 2022')->rows(5),
                                Textarea::make('traction_pm4')->label('Oktober 2022')->rows(5),
                                Textarea::make('traction_pm5')->label('November 2022')->rows(5),
                                Textarea::make('traction_pm6')->label('Desember 2022')->rows(5),
                            ])->visible(fn ($get) => $get('traction_active_user') == 'show'),
                        Select::make('traction_revenue')->label('Apakah startup Anda sudah memiliki revenue?')->options($options)->required()->reactive(),
                        Textarea::make('traction_bm')->label('Jika sudah ada revenue bagaimana bisnis model yang saat ini dipakai?')->rows(5)
                            ->visible(fn ($get) => $get('traction_revenue') == 'show'),
                        Textarea::make('traction_gp')->label('Berapa rata-rata gross profit produk startup Anda dalam 12 bulan terakhir?')->rows(5)
                            ->visible(fn ($get) => $get('traction_revenue') == 'show'),
                    ]),
                Section::make('Others')
                    ->schema([
                        Textarea::make('other_indigo_reason')->label('Apa alasan Anda mengikuti indigo incubator & accelerator? apakah ada yang merekomendasikan Anda untuk mengikuti indigo')->rows(5),
                        TextInput::make('other_indigo_know')->label('Dari mana Anda mengetahui tentang Indigo?')->required(),
                        TextInput::make('other_indigo_recomend')->label('Apakah ada yang merekomendasikan Anda untuk mengikuti Indigo? Siapa?'),
                        Select::make('other_bootcamp_status')->label('Apakah Anda pernah mengikuti program bootcamp / incubator / accelerator sebelumnya?')->required()->options($options)->reactive(),
                        Textarea::make('other_bootcamp')->label('Sebutkan bootcamp / incubator / accelerator tersebut')->rows(5)
                            ->visible(fn ($get) => $get('other_bootcamp_status') == 'show'),
                        FileUpload::make('pitchdeck')->label('Pitch deck')
                            ->hint('Pelajari contoh pitch deck : https://bit.ly/guidelinesdeckindigo2022')
                            ->hintColor('primary')
                            ->helperText('Ukuran file maksimal adalah 2MB dan jenis file adalah PDF.')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegisters::route('/'),
            'create' => Pages\CreateRegister::route('/create'),
            'edit' => Pages\EditRegister::route('/{record}/edit'),
        ];
    }
}