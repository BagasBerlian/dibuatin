<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\File;
use App\Models\User;
use Filament\Tables;
use App\Models\Order;
use App\Models\Package;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FileResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FileResource\RelationManagers;

class FileResource extends Resource
{
    protected static ?string $model = File::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationLabel = 'Files Center';
    protected static ?string $navigationGroup = 'Order';

    protected static ?int $navigationSort = 3;

    protected static ?string $breadcrumb = 'Files Center';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->options(function () {
                        return Project::with(['order', 'order.user'])
                            ->get()
                            ->mapWithKeys(function ($project) {
                                $order = $project->order;
                                $packageName = $order && $order->package ? $order->package->name : 'Unknown Package';
                                $userName = $order && $order->user ? $order->user->name : 'Unknown User';
                                $label = $packageName . ' (' . $userName . ')';
                                return [$project->id => $label];
                            });
                    })
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $project = Project::with('order.package')->find($state);
                        $packageName = $project && $project->order && $project->order->package ? $project->order->package->name : '';

                        $set('file_path', $packageName);

                        if ($state) {
                            $project = Project::find($state);
                            if ($project) {
                                $set('user_id', $project->user_id);
                            }
                        }
                    })
                    ->required(),

                Forms\Components\FileUpload::make('file_name')
                    ->label('File Upload')
                    ->acceptedFileTypes(['image/*', 'application/pdf', 'video/*'])
                    ->required()
                    ->preserveFilenames()
                    ->directory('temp')
                    ->visibility('public')
                    ->maxSize(10 * 1024),

                Forms\Components\TextInput::make('file_path')
                    ->label('File Path')
                    ->disabled()
                    ->required()
                    ->placeholder('Will be automatically filled'),

                Forms\Components\Hidden::make('file_type'),

                Forms\Components\Select::make('user_id')
                    ->label('Assigned Worker')
                    ->options(function () {
                        return User::where('role', 'worker')
                            ->pluck('name', 'id');
                    })
                    ->disabled()
                    ->required()
                    ->placeholder('Will be automatically filled'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_name')
                    ->label('File Name')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(fn($record) => basename($record->file_name))
                    ->wrap(),

                Tables\Columns\TextColumn::make('file_path')
                    ->label('File Path')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('file_type')
                    ->label('File Type')
                    ->searchable()
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_id')
                    ->label('Assigned Worker')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(fn($record) => $record->user ? $record->user->name : 'N/A'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye'),

                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->label('Delete'),
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
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}