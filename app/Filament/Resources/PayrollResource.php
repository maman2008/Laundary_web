<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Filament\Resources\PayrollResource\RelationManagers;
use App\Models\Payroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()->preload()->required(),
                Forms\Components\TextInput::make('period_year')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('period_month')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('amount')->prefix('IDR')
                    ->required()->numeric(),
                Forms\Components\Select::make('status')->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                ])->required(),
                Forms\Components\FileUpload::make('slip_pdf_path')->label('Slip Gaji (PDF)')
                    ->disk('public')->directory('slips')
                    ->acceptedFileTypes(['application/pdf'])
                    ->downloadable()->openable(),
                Forms\Components\FileUpload::make('transfer_proof_path')->label('Bukti Transfer')
                    ->disk('public')->directory('transfer_proofs')
                    ->image()->imageEditor(),
                Forms\Components\DateTimePicker::make('paid_at'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('period_year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('period_month')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slip_pdf_path')->label('Slip')
                    ->url(fn ($record) => $record->slip_pdf_path ? asset('storage/'.ltrim($record->slip_pdf_path,'storage/')) : null, shouldOpenInNewTab: true)
                    ->visible(fn ($record) => !empty($record->slip_pdf_path)),
                Tables\Columns\ImageColumn::make('transfer_proof_path')->label('Bukti')
                    ->disk('public')->height(40),
                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_paid')->label('Tandai Paid')
                    ->visible(fn ($record) => $record->status !== 'paid')
                    ->action(function ($record) {
                        $record->status = 'paid';
                        $record->paid_at = now();
                        $record->save();
                    }),
                Tables\Actions\Action::make('generate_slip')->label('Generate Slip PDF')
                    ->action(function ($record) {
                        $html = view('pdf.slip', ['record' => $record, 'user' => $record->user])->render();
                        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
                        $fileName = 'slips/'.date('Y/m').'/slip_'.($record->user->username ?? $record->user->id).'_'.sprintf('%04d%02d', $record->period_year, $record->period_month).'.pdf';
                        \Storage::disk('public')->put($fileName, $pdf->output());
                        $record->slip_pdf_path = $fileName;
                        $record->save();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }
}

