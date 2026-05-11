<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Http\Requests\NovaRequest;

class Note extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Note>
     */
    public static $model = \App\Models\Note::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'slug',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug')->from('Title')->hideFromIndex(),

            BelongsTo::make('User')->sortable()->filterable(),

            BelongsTo::make('Category')->sortable()->filterable(),

            BelongsTo::make('University')->sortable()->filterable(),

            BelongsTo::make('Subject')->sortable()->filterable(),

            Badge::make('Status')->map([
                'pending' => 'warning',
                'approved' => 'success',
                'rejected' => 'danger',
            ])->sortable(),

            Number::make('AI Score')->sortable()->displayUsing(fn ($val) => number_format($val * 100, 1) . '%'),

            Boolean::make('Is Premium', 'is_premium')->sortable(),

            Markdown::make('Content')->alwaysShow()->hideFromIndex(),

            Select::make('Visibility')->options([
                'public' => 'Public',
                'private' => 'Private',
                'followers' => 'Followers Only',
            ])->sortable()->rules('required'),

            Number::make('Views', 'views_count')->sortable()->exceptOnForms(),
            Number::make('Likes', 'likes_count')->sortable()->exceptOnForms(),
            Number::make('Saves', 'saves_count')->sortable()->exceptOnForms(),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [
            new \App\Nova\Filters\NoteVisibility,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
