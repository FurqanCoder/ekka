<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;

class PwaInstallPopup extends Component
{
    public $showPopup = false;
    public $isInstalled = false;
    public $isIOS = false;
    public $isAndroid = false;
    public $deferredPrompt = null;

    public function mount()
    {
        // Check if already installed from session
        $this->isInstalled = session('pwa_installed', false);
        
        // Check if user dismissed the popup
        $dismissed = session('pwa_dismissed', false);
        
        // Detect device
        $this->isIOS = $this->detectIOS();
        $this->isAndroid = $this->detectAndroid();
        
        // Show popup if not installed and not dismissed
        if (!$this->isInstalled && !$dismissed && !$this->isInStandaloneMode()) {
            $this->showPopup = true;
        }
    }

    public function detectIOS()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return strpos($userAgent, 'iPhone') !== false || 
               strpos($userAgent, 'iPad') !== false ||
               strpos($userAgent, 'iPod') !== false;
    }

    public function detectAndroid()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return strpos($userAgent, 'Android') !== false;
    }

    public function isInStandaloneMode()
    {
        // Check if already in PWA mode
        return request()->header('X-Requested-With') === 'XMLHttpRequest' ||
               request()->has('pwa') ||
               (isset($_SERVER['HTTP_USER_AGENT']) && 
                (strpos($_SERVER['HTTP_USER_AGENT'], 'standalone') !== false));
    }

    public function installApp()
    {
        if ($this->isIOS) {
            // For iOS - show detailed guide
            $this->dispatch('show-ios-guide');
        } else {
            // For Android and other browsers
            $this->dispatch('trigger-install');
        }
    }

    public function dismissPopup()
    {
        $this->showPopup = false;
        session(['pwa_dismissed' => true]);
        session(['pwa_installed' => false]);
    }

    public function markInstalled()
    {
        $this->isInstalled = true;
        $this->showPopup = false;
        session(['pwa_installed' => true]);
        session(['pwa_dismissed' => false]);
    }

    public function render()
    {
        return view('livewire.web.components.pwa-install-popup');
    }
}