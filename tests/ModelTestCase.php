<?php

namespace NathanDunn\Countries\Tests;

use Illuminate\Support\Collection;
use NathanDunn\Countries\Tests\TestCase;

abstract class ModelTestCase extends TestCase
{
    protected string $model;

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf($this->model, new $this->model());
    }

    /** @test */
    public function it_has_a_factory()
    {
        $this->assertInstanceOf($this->model, $this->model::factory()->create());
    }

    public function belongsToTest($otherModel, $relationMethod, $relatedForeignKey)
    {
        // Given there is a model
        $model = $this->model::factory()->make([
            $relatedForeignKey => null,
        ]);

        // And a related model
        $relatedModel = $otherModel::factory()->create();

        // When I associate the related model to the model
        $model->$relationMethod()->associate($relatedModel);
        $model->save();

        // The model now belongs to that related model
        $this->assertEquals($relatedModel->id, $model->$relatedForeignKey);
        $this->assertEquals($relatedModel, $model->$relationMethod);
    }

    public function belongsToManyTest(
        $otherModel,
        $relationMethod,
        $pivotModel = null,
        $pivotData = []
    )
    {
        // Given there is a model
        $model = $this->model::factory()->create();

        // And there are 3 other models for it to belong to
        $belongsTo = $otherModel::factory()->count(3)->create();

        $belongsToIds = $belongsTo->map(function ($individualBelongsToModel) {
            return $individualBelongsToModel->id;
        })->sort()->toArray();

        $mappedPivotData = $belongsToIds;

        if (!empty($pivotData)) {
            $mappedPivotData = $belongsTo->mapWithKeys(function ($individualBelongsToModel) use ($pivotData) {
                return [$individualBelongsToModel->id => $pivotData];
            })->toArray();
        }

        // When I sync the model with the belongs to ids
        $model->$relationMethod()->sync($mappedPivotData);

        // Then I see the model has 3 belongs to models
        $this->assertEquals(3, $model->$relationMethod()->count());
        $this->assertInstanceOf(Collection::class, $model->$relationMethod);

        // The belongs to ids associated wih the model match the belongs to ids assigned to it
        $model->$relationMethod->each(function ($belongsTo) use ($belongsToIds) {
            $this->assertContains($belongsTo->id, $belongsToIds);
        });

        if ($pivotModel) {
            $this->assertInstanceOf(
                $pivotModel,
                $model->$relationMethod()->first()->pivot
            );
        }
    }

    public function hasManyTest($otherModelClass, $relationMethodName, $foreignKeyProperty, $foreignRelationMethodName)
    {
        // Given there is a model
        $model = $this->model::factory()->create();

        // And there are 3 other models
        $otherModels = $otherModelClass::factory()->count(3)->make([$foreignKeyProperty => null]);

        // When I associate the model with the other models
        $model->$relationMethodName()->saveMany($otherModels);

        // Then I see the model has 3 other models
        $this->assertEquals(3, $model->$relationMethodName()->count());
        $this->assertInstanceOf(Collection::class, $model->$relationMethodName);

        // And I see the other models now belong to the model
        $otherModels->each(function ($otherModel) use ($model, $foreignRelationMethodName) {
            $this->assertEquals($model->id, $otherModel->$foreignRelationMethodName->id);
        });
    }
}
