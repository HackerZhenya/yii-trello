<?php

namespace app\models;

use app\traits\HasNotSoShittyAttributes;
use app\traits\HasTimestamps;
use JetBrains\PhpStorm\Pure;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\models
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $createdAt
 * @property string $updatedAt
 */
class User extends ActiveRecord implements IdentityInterface
{
    use HasNotSoShittyAttributes, HasTimestamps;

    private static array $hashes = [];

    public static function tableName(): string
    {
        return 'users';
    }

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): static|null
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): static|null
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username): static|ActiveRecord|null
    {
        return static::findOne(
            new Expression('lower(username) = :username',
                           ['username' => strtolower($username)]));
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * @param string $password
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->setAttribute('password', password_hash($password, PASSWORD_BCRYPT));
    }

    private function getUsernameHashCode(): int
    {
        if (!array_key_exists($this->username, self::$hashes)) {
            self::$hashes[$this->username] = getStringHashCode($this->username);
        }

        return self::$hashes[$this->username];
    }

    /** @noinspection PhpPureAttributeCanBeAddedInspection */
    public function getHolderTheme(): string
    {
        return HOLDER_THEMES[$this->getUsernameHashCode() % count(HOLDER_THEMES)];
    }
}
