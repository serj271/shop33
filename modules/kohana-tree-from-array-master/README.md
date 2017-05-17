##  Генерация дерева элементов из массива

Данный модуль позволяет из обычного массива элементов генерировать дерево.

**_Массив доложен содержать два поля:_**
* id
* parent_id


###  Пример
**Получаем данные из БД**

`$categories = DB::select('*')->from('categories')->order_by('parent_id', 'asc')->order_by('id', 'asc')->as_object()->execute();`

***

**Передаем их в модель Model_Tree**

`$tree = Model_Tree::factory($categories)->execute();`

***

**Получение в виде плоского массива Model_Tree_Item**

`$array = Model_Tree::factory($categories)->flatten()->execute();`

**Кеширование массива**

`$array = Model_Tree::factory($categories)->cached()->execute();`
`$array = Model_Tree::factory($categories)->cached(3600, 'tree_cache_key')->execute();`

***

**Поиск элемента по ID**

`$children = $tree->current()->children();`