<?php

namespace app\models;

use yii\base\Model;

class MultiWordsForm extends Model
{
    public string $words = '';
    public ?int $categoryId = null;

    public function rules()
    {
        return [
            [['words'], 'string'],
            [['categoryId'], 'integer'],
            [['categoryId', 'words'], 'required'],
            [['categoryId'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'categoryId'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'categoryId' => 'Категория',
            'words' => 'Список слов (одно слово на одну строку)'
        ];
    }

    public function save()
    {
        $this->words = trim($this->words);
        $words = explode(PHP_EOL, $this->words);

        foreach ($words as $word) {
            $word = trim($word);
            $wordExists = Words::find()
                ->where(['name' => $word])
                ->andWhere(['category_id' => $this->categoryId])
                ->exists();

            if ($word && !$wordExists) {
                $wordModel = new Words();
                $wordModel->name = $word;
                $wordModel->category_id = $this->categoryId;
                if(!$wordModel->save()) {
                    var_dump($wordModel->errors);
                    die;
                }
            }
        }
    }
}