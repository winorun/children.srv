<?php if ($currentUser->hasAccessTo('lhgenericbot','use') ) : ?>
    <h5><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/configuration','Bot');?></h5>
    <ul>
        <li><a href="<?php echo erLhcoreClassDesign::baseurl('genericbot/list')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/configuration','Bot list');?></a></li>
    </ul>
<?php endif; ?>