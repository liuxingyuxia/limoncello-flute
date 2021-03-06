<?php namespace App\Api;

use App\Authentication\Contracts\AccountManagerInterface;
use App\Database\Models\Comment as Model;
use App\Database\Models\User;

/**
 * @package App
 */
class CommentsApi extends BaseApi
{
    const MODEL = Model::class;

    /**
     * @inheritdoc
     */
    public function create(array $attributes, array $toMany = [])
    {
        /** @var AccountManagerInterface $accountManager */
        $accountManager = $this->getContainer()->get(AccountManagerInterface::class);

        // user must be signed-in
        $currentUser = $accountManager->getAccount()->getUser();
        $attributes[Model::FIELD_ID_USER] = $currentUser->{User::FIELD_ID};

        return parent::create($attributes, $toMany);
    }
}
