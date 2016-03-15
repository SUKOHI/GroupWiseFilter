# GroupWiseFilter
A Laravel package to get row(s) with the group-wise maximum or minimum.

(This is for Laravel 4.2. [For Laravel 5](https://github.com/SUKOHI/GroupWiseFilter))

# Installation

Execute composer command.

    composer require sukohi/group-wise-filter:1.*

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
    $items = Item::groupMax($column, $group_by)->get();

**with select(), where() and so on..**  

You should add table name like this.

    $items = Item::select(
                    'items.id',
                    'items.title'
                    'items.area_id'
                );
                
**Order by Group**
    
    Item::orderByGroup('ASC');
    Item::orderByGroup('DESC');
             
**Grouped table and Grouped table**

You can use `GROUP_TABLE` and `GROUP_VALUE` like this.

    $items = Item::select('GROUP_TABLE.GROUP_VALUE');

License
====
This package is licensed under the MIT License.

Copyright 2016 Sukohi Kuhoh