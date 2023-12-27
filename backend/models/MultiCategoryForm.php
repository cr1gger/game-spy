<?php

namespace app\models;

use yii\base\Model;

class MultiCategoryForm extends Model
{
    public string $categories = '';

    public function rules()
    {
        return [
            [['categories'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'categories' => 'Список категории (одна категория на одну строку)',
        ];
    }

    public function save(): void
    {
        $this->categories = trim($this->categories);
        $categories = explode(PHP_EOL, $this->categories);

        foreach ($categories as $category) {
            $category = trim($category);
            $categoryExists = Category::find()->where(['name' => $category])->exists();

            if ($category && !$categoryExists) {
                $categoryModel = new Category();
                $categoryModel->name = $category;
                $categoryModel->save();
            }
        }
    }
}