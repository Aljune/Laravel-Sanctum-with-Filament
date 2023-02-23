<?php

namespace App\Filament\Resources\TagReourceResource\RelationManagers;

use App\Models\Post;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\BelongsToSelect::make('category_id')
                    ->relationship('category','name'),
                    Forms\Components\TextInput::make('title')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    })->required()
                    ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('slug')->required()
                        ->disabled(fn (?Post $record) => $record !== null)
                        ->unique(ignoreRecord: true)
                        ->rules('alpha_dash')
                        ->disabled(),
                    SpatieMediaLibraryFileUpload ::make('thumbnail')->collection('posts'),
                    Forms\Components\RichEditor::make('content')
                    ->required(),
                    Forms\Components\Toggle::make('is_published'),
                    Forms\Components\BelongsToSelect::make('user_id')->relationship('user', 'name')
                        ->default(Auth::user()->id),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(50)->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->limit(50),
                Tables\Columns\TextColumn::make('content')->html(),
                Tables\Columns\BooleanColumn::make('is_published'),
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('posts'),
                ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
