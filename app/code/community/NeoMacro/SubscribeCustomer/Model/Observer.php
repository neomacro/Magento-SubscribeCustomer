<?php

class NeoMacro_SubscribeCustomer_Model_Observer extends Mage_Core_Model_Abstract
{
    public function subscribe($observer)
    {
        $customer = $observer->getEvent()->getCustomer();

        $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($customer->getEmail());

        if (!$subscriber->getId()) {
            $subscriber->setCustomerId($customer->getId());
            $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
            $subscriber->setStoreId($customer->getStore()->getId());
            $subscriber->setSubscriberEmail($customer->getEmail());
            $subscriber->setSubscriberConfirmCode($subscriber->RandomSequence());

            try {
                $subscriber->save();
            } catch (Exception $e) {
                // Intentionally does nothing!
            }
        }
    }
}
