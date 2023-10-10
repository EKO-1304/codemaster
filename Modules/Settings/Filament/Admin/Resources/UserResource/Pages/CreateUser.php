<?php

namespace Modules\Settings\Filament\Admin\Resources\UserResource\Pages;

use Modules\Settings\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
