<?php

namespace app\requests\users;

use app\models\User;
use Yii;
use yii\base\Model;

class SignUpRequest extends Model
{
    public string $username = '';
    public string $password = '';
    public string $confirmPassword = '';

    private User|bool|null $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['username', 'password', 'confirmPassword'], 'required'],
            ['username', 'string', 'min' => 3],
            ['username', 'validateUsername'],
            ['password', 'string', 'min' => 6],
            ['confirmPassword', 'validateConfirmPassword'],
        ];
    }

    public function validateUsername(string $attribute, ?array $params): void
    {
        if (!$this->hasErrors()) {
            if ($this->getUser()) {
                $this->addError($attribute, 'Username already exists.');
            }
        }
    }

    public function validateConfirmPassword(string $attribute, ?array $params): void
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->confirmPassword) {
                $this->addError($attribute, 'Wrong password confirmation.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function signUp(): bool
    {
        if ($this->validate()) {
            $user = new User;

            $user->username = $this->username;
            $user->password = $this->password;
            return $user->save();
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser(): User|null
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
