<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeRequestResource\Pages;
use App\Filament\Resources\EmployeeRequestResource\RelationManagers;
use App\Models\EmployeeRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class EmployeeRequestResource extends Resource
{
    protected static ?string $model = EmployeeRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()->preload()->required(),
                Forms\Components\Select::make('type')->options([
                    'damage' => 'Kerusakan',
                    'shortage' => 'Barang Kurang',
                    'leave' => 'Izin',
                ])->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
                Forms\Components\FileUpload::make('attachment_path')->label('Lampiran')
                    ->disk('public')->directory('employee_requests')->openable()->downloadable(),
                Forms\Components\Select::make('status')->options([
                    'pending' => 'Pending',
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                ])->required(),
                Forms\Components\TextInput::make('reviewed_by')->numeric()->disabled()->dehydrated(false),
                Forms\Components\DateTimePicker::make('reviewed_at')->disabled()->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attachment_path')->label('Lampiran')
                    ->url(fn ($record) => $record->attachment_path ? asset('storage/'.ltrim($record->attachment_path,'storage/')) : null, shouldOpenInNewTab: true)
                    ->visible(fn ($record) => !empty($record->attachment_path)),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reviewed_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_at')
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
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('accept')->label('Accept')
                    ->visible(fn ($record) => $record->status !== 'accepted')
                    ->action(function ($record) {
                        $record->status = 'accepted';
                        $record->reviewed_by = Auth::id();
                        $record->reviewed_at = now();
                        $record->save();
                    }),
                Tables\Actions\Action::make('reject')->label('Reject')
                    ->visible(fn ($record) => $record->status !== 'rejected')
                    ->action(function ($record) {
                        $record->status = 'rejected';
                        $record->reviewed_by = Auth::id();
                        $record->reviewed_at = now();
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
            'index' => Pages\ListEmployeeRequests::route('/'),
            'create' => Pages\CreateEmployeeRequest::route('/create'),
            'edit' => Pages\EditEmployeeRequest::route('/{record}/edit'),
        ];
    }
}

