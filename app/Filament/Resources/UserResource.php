<?php


namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = "User Management";
    
    protected static ?int $navigationSort = 1;

    //protected static ?string $slug = 'pending-orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                    ->reactive()
                    ->required(),
                    Forms\Components\TextInput::make('email')
                    ->email()
                    ->dehydrated(fn ($state) => filled($state))
                    ->unique(ignoreRecord:true)
                    ->reactive()
                    ->required(),
                    Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255)
                    ->disableAutocomplete()
                    ->confirmed()
                    //->autocomplete('new-password')
                    ->required(fn(Page $livewire) => ($livewire instanceof CreateUser)),
                    // ->disabled(fn (?User $record) => $record !== 'null'),
                    Forms\Components\TextInput::make('password_confirmation')
                    ->disableAutocomplete()
                    ->password(),

                    Forms\Components\Select::make('roles')
                    ->multiple()
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.roles'))
                    ->relationship('roles', 'name')
                    // ->preload(config('filament-spatie-roles-permissions.preload_roles'))
                    ->preload(),


                    Forms\Components\Select::make('permissions')
                    ->multiple()
                    ->label(__('filament-spatie-roles-permissions::filament-spatie.field.permissions'))
                    ->relationship('permissions', 'name')
                    // ->preload(config('filament-spatie-roles-permissions.preload_permissions'))
                    ->preload()

                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
            ])
            ->defaultSort('name')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
