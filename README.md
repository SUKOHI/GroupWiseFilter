# GroupWiseFilter
A Laravel package to get row(s) with the group-wise maximum or minimum.

(This is for Laravel 5+. [For Laravel 4.2](https://github.com/SUKOHI/GroupWiseFilter/tree/1.0))

# Installation

Execute composer command.

    composer require sukohi/group-wise-filter:2.*

# Preparation

In your model, set GroupWiseFilterTrait.

    use Sukohi\GroupWiseFilter\GroupWiseFilterTrait;
    
    class Item extends model
    {
        use GroupWiseFilterTrait;
    }

Now you can call `groupMax()` and `groupMin()`.

# Usage

**Simplest Way**  

    $column = 'amount';
    $group_by = 'area_id';
    $items = \App\Item::groupMax($column, $group_by)->get();

**with select(), where() and so on..**  

You should add table name like this.

    $items = \App\Item::select(
                    'items.id',
                    'items.title'
                    'items.area_id'
                );
                
**Grouped table and Grouped table**

You can use `GROUP_TABLE` and `GROUP_VALUE` like this.

		$items = \App\Item::select('GROUP_TABLE.GROUP_VALUE')->orderBy('GROUP_TABLE.GROUP_VALUE', 'ASC');

License
====
This package is licensed under the MIT License.

Copyright 2016 Sukohi Kuhoh