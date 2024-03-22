<?php
    $accounts_user_html = '';
    $accounts_user_active_html ='';
    $userList = [];
    $id_user = $_SESSION['userLogin']['id_user'];
    foreach ($_COOKIE as $name => $value) {
        if (str_starts_with($name, "accounts_user")) {
            $accounts_user = get_accountUser($value);
            $userList[$value] = $accounts_user;
        }
    }
    if(is_array($userList) && $userList != "") {
        foreach ($userList as $item) {
            foreach ($item as $key) {
                extract($key);
                if($img == "") {
                    $avatar_account = USER_PATH.'avatar-none.png';
                }else {
                    $avatar_account = USER_PATH.$img;
                }
                if($id == $_SESSION['userLogin']['id_user']) {
                    $accounts_user_active_html ='<div class="box__listAccount--item">
                                                    <div class="box__avatar--account">
                                                        <img srcset="'.$avatar_account.' 2x" alt="">
                                                    </div>
                                                    <div class="box__info--account">
                                                        <span class="info--account_name">'.$username.'</span>
                                                        <span class="info--account_email">'.$email.'</span>
                                                    </div>
                                                </div>';
                    
                }else {
                    $accounts_user_html .= '<a href="?mod=user&act=change_account&id='.$id.'" style="color: black;">
                                                <div class="box__listAccount--item account__notActive">
                                                    <div class="box__avatar--account">
                                                        <img srcset="'.$avatar_account.' 2x" alt="">
                                                    </div>
                                                    <div class="box__info--account">
                                                        <span class="info--account_name">'.$username.'</span>
                                                        <span class="info--account_email">'.$email.'</span>
                                                    </div>
                                                </div>
                                            </a>';
                }
            }
        }
    }
?>
<div class="box__changeAccount">
    <svg viewBox="0 0 20 20" fill="currentColor" class="x1lliihq x1k90msu x2h7rmj x1qfuztq xfuq9xy x10w6t97 x1td3qas"><g fill-rule="evenodd" transform="translate(-446 -398)"><g fill-rule="nonzero"><path d="M96.628 206.613A7.97 7.97 0 0 1 96 203.5a7.967 7.967 0 0 1 2.343-5.657A7.978 7.978 0 0 1 104 195.5a7.978 7.978 0 0 1 5.129 1.86.75.75 0 0 0 .962-1.15A9.479 9.479 0 0 0 104 194a9.478 9.478 0 0 0-6.717 2.783A9.467 9.467 0 0 0 94.5 203.5a9.47 9.47 0 0 0 .747 3.698.75.75 0 1 0 1.381-.585zm14.744-6.226A7.97 7.97 0 0 1 112 203.5a7.967 7.967 0 0 1-2.343 5.657A7.978 7.978 0 0 1 104 211.5a7.978 7.978 0 0 1-5.128-1.86.75.75 0 0 0-.962 1.152A9.479 9.479 0 0 0 104 213a9.478 9.478 0 0 0 6.717-2.783 9.467 9.467 0 0 0 2.783-6.717 9.47 9.47 0 0 0-.747-3.698.75.75 0 1 0-1.381.585z" transform="translate(352 204.5)"></path><path d="M109.5 197h-2.25a.75.75 0 1 0 0 1.5h3a.75.75 0 0 0 .75-.75v-3a.75.75 0 1 0-1.5 0V197zm-11 13h2.25a.75.75 0 1 0 0-1.5h-3a.75.75 0 0 0-.75.75v3a.75.75 0 1 0 1.5 0V210z" transform="translate(352 204.5)"></path></g></g></svg>

    <div class="box__changeAccount--content box-shadow4">
        <div class="box__listAccount">
            <?= $accounts_user_active_html ?>
            <hr class="hr__account">
            <?= $accounts_user_html ?>
    </div>
        <div class="box__changeAccount--logOut">
            <a href="?mod=user&act=logOut-account&id-account=<?= $id_user ?>" class="box__changeAccount--logOut__button" style="color: black;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Đăng xuất</span>
            </a>
        </div>
    </div>
</div>