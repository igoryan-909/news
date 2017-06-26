<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PostNotice;

/**
 * PostNoticeSearch represents the model behind the search form about `app\models\PostNotice`.
 */
class PostNoticeSearch extends PostNotice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_post_notice', 'fk_post', 'fk_user', 'read_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PostNotice::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_post_notice' => $this->id_post_notice,
            'fk_post' => $this->fk_post,
            'fk_user' => $this->fk_user,
            'read_at' => $this->read_at,
        ]);

        return $dataProvider;
    }
}
