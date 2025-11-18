<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DateTimePicker::make('check_in_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('check_out_at'),
                Forms\Components\TextInput::make('photo_path')->disabled()->dehydrated(false),
                Forms\Components\TextInput::make('lat')
                    ->numeric(),
                Forms\Components\TextInput::make('lng')
                    ->numeric(),
                Forms\Components\Toggle::make('is_late')
                    ->required(),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('check_in_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_out_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('photo_path')->label('Photo')
                    ->disk('public')->height(50),
                Tables\Columns\TextColumn::make('lat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lng')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_late')
                    ->boolean(),
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
                Tables\Filters\Filter::make('late')->label('Hanya Telat')
                    ->query(fn (Builder $q) => $q->where('is_late', true)),
                Tables\Filters\Filter::make('today')->label('Hari Ini')
                    ->query(fn (Builder $q) => $q->whereDate('check_in_at', now()->toDateString())),
                Tables\Filters\Filter::make('date_range')->form([
                    Forms\Components\DatePicker::make('from'),
                    Forms\Components\DatePicker::make('until'),
                ])->query(function (Builder $q, array $data) {
                    return $q
                        ->when($data['from'] ?? null, fn ($qq, $d) => $qq->whereDate('check_in_at', '>=', $d))
                        ->when($data['until'] ?? null, fn ($qq, $d) => $qq->whereDate('check_in_at', '<=', $d));
                }),
            ])
            ->actions([
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}

