<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Da\User\Factory;

use Da\User\Contracts\MailChangeStrategyInterface;
use Da\User\Form\SettingsForm;
use Da\User\Strategy\DefaultEmailChangeStrategy;
use Da\User\Strategy\InsecureEmailChangeStrategy;
use Da\User\Strategy\SecureEmailChangeStrategy;
use Exception;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidParamException;

class EmailChangeStrategyFactory
{
    protected static $map = [
        MailChangeStrategyInterface::TYPE_INSECURE => InsecureEmailChangeStrategy::class,
        MailChangeStrategyInterface::TYPE_DEFAULT => DefaultEmailChangeStrategy::class,
        MailChangeStrategyInterface::TYPE_SECURE => SecureEmailChangeStrategy::class,
    ];

    /**
     * @param $strategy
     *
     * @throws Exception
     * @return MailChangeStrategyInterface
     *
     */
    public static function makeByStrategyType($strategy, SettingsForm $form)
    {
        if (array_key_exists($strategy, static::$map)) {
            /** @var MailChangeStrategyInterface $object */
            $object = Yii::$container->get(static::$map[$strategy], [$form]);
            return $object;
        }

        throw new InvalidArgumentException('Unknown strategy type');
    }

    /**
     * @return DefaultEmailChangeStrategy
     */
    public static function makeDefaultEmailChangeStrategy(SettingsForm $form)
    {
        /** @var DefaultEmailChangeStrategy $object */
        $object = Yii::$container->get(static::$map[MailChangeStrategyInterface::TYPE_DEFAULT], [$form]);
        return $object;
    }

    /**
     * @return InsecureEmailChangeStrategy
     */
    public static function makeInsecureEmailChangeStrategy(SettingsForm $form)
    {
        /** @var InsecureEmailChangeStrategy $object */
        $object =Yii::$container->get(static::$map[MailChangeStrategyInterface::TYPE_INSECURE], [$form]);
        return $object;
    }

    /**
     * @return SecureEmailChangeStrategy
     */
    public static function makeSecureEmailChangeStrategy(SettingsForm $form)
    {
        /** @var SecureEmailChangeStrategy $object */
        $object = Yii::$container->get(static::$map[MailChangeStrategyInterface::TYPE_SECURE], [$form]);
        return $object;
    }
}
