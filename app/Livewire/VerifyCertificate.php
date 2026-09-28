<?php

namespace App\Livewire;

use App\Models\DtsenCertificate;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Verifikasi Keaslian Surat — SAPA SOSIAL')]
class VerifyCertificate extends Component
{
    #[Url]
    public string $code = '';

    public bool $hasChecked = false;

    public function mount(?string $code = null): void
    {
        if ($code) {
            $this->code = strtoupper(trim($code));
            $this->hasChecked = true;
        }
    }

    public function check(): void
    {
        $this->validate([
            'code' => 'required|string|min:4',
        ], [
            'code.required' => 'Kode verifikasi wajib diisi.',
        ]);

        $this->code = strtoupper(trim($this->code));
        $this->hasChecked = true;
    }

    public function render(): View
    {
        $certificate = null;
        $isValid = false;
        $isExpired = false;

        if ($this->hasChecked && filled($this->code)) {
            $certificate = DtsenCertificate::with(['serviceRequest', 'dtsenPurpose', 'signer'])
                ->where('verification_code', $this->code)
                ->whereNotNull('certificate_number')
                ->first();

            if ($certificate) {
                if ($certificate->valid_until && $certificate->valid_until->isPast()) {
                    $isExpired = true;
                    $isValid = false;
                } else {
                    $isValid = true;
                }
            }
        }

        return view('livewire.verify-certificate', [
            'certificate' => $certificate,
            'isValid' => $isValid,
            'isExpired' => $isExpired,
        ]);
    }
}
