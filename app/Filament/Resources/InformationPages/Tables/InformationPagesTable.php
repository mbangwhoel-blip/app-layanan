<?php

namespace App\Filament\Resources\InformationPages\Tables;

use App\Enums\InformationCategory;
use App\Enums\PublishStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class InformationPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Halaman')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                TextColumn::make('publish_status')
                    ->label('Status Tayang')
                    ->badge()
                    ->sortable(),
                TextColumn::make('downloadable_forms_count')
                    ->counts('downloadableForms')
                    ->label('Formulir')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('faqs_count')
                    ->counts('faqs')
                    ->label('FAQ')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Tgl Publikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('manager.name')
                    ->label('Pengelola')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Filter Kategori')
                    ->options(InformationCategory::class),
                SelectFilter::make('publish_status')
                    ->label('Filter Status Tayang')
                    ->options(PublishStatus::class),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
