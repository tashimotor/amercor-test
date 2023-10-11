<?php

namespace app\models;

use app\models\enums\HistoryEventTypeEnum;
use app\models\traits\WithPolymorphRelationsTrait;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\AttributeTypecastBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%history}}".
 *
 * @property integer $id
 * @property string $ins_ts
 * @property integer $customer_id
 * @property HistoryEventTypeEnum $event
 * @property string $object
 * @property integer $object_id
 * @property ?string $message
 * @property ?string $detail
 * @property ?integer $user_id
 *
 * @property string $eventText
 *
 * @property Customer $customer
 * @property ?User $user
 *
 * @property ?Task $task
 * @property ?Sms $sms
 * @property ?Call $call
 * @property ?Fax $fax
 */
class History extends ActiveRecord
{
    use WithPolymorphRelationsTrait;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ins_ts'], 'safe'],
            [['customer_id', 'object_id', 'user_id'], 'integer'],
            [['event'], 'required'],
            [['message', 'detail'], 'string'],
            [['event', 'object'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'typecast' => [
                'class'                 => AttributeTypecastBehavior::class,
                'attributeTypes'        => [
                    'event' => fn($value) => HistoryEventTypeEnum::tryFrom($value)
                        ?? throw new InvalidConfigException($value.' not supported by HistoryEventTypeEnum'),

                ],
                'typecastAfterValidate' => false,
                'typecastBeforeSave'    => false,
                'typecastAfterFind'     => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ins_ts' => Yii::t('app', 'Ins Ts'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'event' => Yii::t('app', 'Event'),
            'object' => Yii::t('app', 'Object'),
            'object_id' => Yii::t('app', 'Object ID'),
            'message' => Yii::t('app', 'Message'),
            'detail' => Yii::t('app', 'Detail'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getEventText(): string
    {
        return $this->event->text();
    }

    /**
     * @param $attribute
     * @return null
     */
    public function getDetailChangedAttribute($attribute)
    {
        $detail = json_decode($this->detail);
        return isset($detail->changedAttributes->{$attribute}) ? $detail->changedAttributes->{$attribute} : null;
    }

    /**
     * @param $attribute
     * @return null
     */
    public function getDetailOldValue($attribute)
    {
        $detail = $this->getDetailChangedAttribute($attribute);
        return isset($detail->old) ? $detail->old : null;
    }

    /**
     * @param $attribute
     * @return null
     */
    public function getDetailNewValue($attribute)
    {
        $detail = $this->getDetailChangedAttribute($attribute);
        return isset($detail->new) ? $detail->new : null;
    }

    /**
     * @param $attribute
     * @return null
     */
    public function getDetailData($attribute)
    {
        $detail = json_decode($this->detail);
        return isset($detail->data->{$attribute}) ? $detail->data->{$attribute} : null;
    }
}
