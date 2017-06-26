<?php

namespace app\models;

use kartik\daterange\DateRangeBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form about `app\models\Post`.
 */
class PostSearch extends Post
{
    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_post', 'updated_at'], 'integer'],
            [['fkUser.username', 'created_at', 'preview', 'content', 'title'], 'safe'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['fkUser.username']);
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
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['fkUser']);
        $dataProvider->sort->attributes['fkUser.username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_post' => $this->id_post,
            'fk_user' => $this->fk_user,
        ]);

        /*if (mb_strpos($this->created_at, ' - ', 0, 'UTF-8') !== false) {
            list($startDate, $endDate) = explode(' - ', $this->created_at);
            $query->andFilterWhere([
                'between',
                'post.created_at',
                (new \DateTime($startDate))->getTimestamp(),
                (new \DateTime($endDate))->getTimestamp(),
            ]);
        }*/
        $query->andFilterWhere(['>=', 'post.created_at', $this->createTimeStart])
            ->andFilterWhere(['<', 'post.created_at', $this->createTimeEnd]);

        $query->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('fkUser.username')])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
