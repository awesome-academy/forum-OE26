<?php

namespace Tests;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function relation_test_hasMany($relation, $foreignKey, $related)
    {
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals($foreignKey, $relation->getForeignKeyName());
        $this->assertInstanceOf($related, $relation->getRelated());
    }

    public function relation_test_belongsTo($relation, $foreignKey, $relationName, $related)
    {
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals($foreignKey, $relation->getForeignKeyName());
        $this->assertEquals($relationName, $relation->getRelationName());
        $this->assertInstanceOf($related, $relation->getRelated());
    }

    public function relation_test_belongsToMany($relation, $foreignPivotKey, $relatedPivotKey, $relatedKey, $relationName, $related)
    {
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertEquals($foreignPivotKey, $relation->getForeignPivotKeyName());
        $this->assertEquals($relatedPivotKey, $relation->getRelatedPivotKeyName());
        $this->assertEquals($relatedKey, $relation->getRelatedKeyName());
        $this->assertEquals($relationName, $relation->getRelationName());
        $this->assertInstanceOf($related, $relation->getRelated());
    }

    public function relation_test_morphMany($relation, $morphType, $foreignKey, $related)
    {
        $this->assertInstanceOf(MorphMany::class, $relation);
        $this->assertEquals($morphType, $relation->getMorphType());
        $this->assertEquals($foreignKey, $relation->getForeignKeyName());
        $this->assertInstanceOf($related, $relation->getRelated());
    }

    public function relation_test_morphTo($relation, $related)
    {
        $this->assertInstanceOf(MorphTo::class, $relation);
        $this->assertInstanceOf($related, $relation->getRelated());
    }
}
