<?php

namespace App\Traits;

use App\Models\SessionAuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            $model->logAudit('create', 'تم إنشاء ' . $model->getAuditModelName());
        });

        static::updated(function ($model) {
            $model->logAudit('update', 'تم تحديث ' . $model->getAuditModelName(), $model->getOriginal(), $model->getAttributes());
        });

        static::deleted(function ($model) {
            $model->logAudit('delete', 'تم حذف ' . $model->getAuditModelName());
        });
    }

    public function logAudit($action, $description, $oldValues = null, $newValues = null)
    {
        if (!$this->shouldLogAudit()) {
            return;
        }

        $sessionId = $this->getSessionId();
        
        if (!$sessionId) {
            return;
        }

        SessionAuditLog::create([
            'session_id' => $sessionId,
            'user_id' => Auth::id(),
            'action' => $action,
            'action_type' => $this->getAuditActionType(),
            'description' => $description,
            'old_values' => $oldValues ? $this->filterAuditValues($oldValues) : null,
            'new_values' => $newValues ? $this->filterAuditValues($newValues) : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    protected function shouldLogAudit()
    {
        return true; // يمكن تخصيص هذا حسب الحاجة
    }

    protected function getSessionId()
    {
        // يمكن تخصيص هذا حسب النموذج
        if (method_exists($this, 'session')) {
            return $this->session_id ?? null;
        }
        
        return null;
    }

    protected function getAuditModelName()
    {
        return class_basename($this);
    }

    protected function getAuditActionType()
    {
        $className = class_basename($this);
        
        $types = [
            'Session' => 'session',
            'SessionPayment' => 'payment',
            'SessionDrink' => 'drink',
        ];

        return $types[$className] ?? 'other';
    }

    protected function filterAuditValues($values)
    {
        // إزالة الحقول التي لا نريد تسجيلها
        $excludedFields = [
            'updated_at',
            'created_at',
            'remember_token',
            'password',
        ];

        return array_diff_key($values, array_flip($excludedFields));
    }

    // Helper method لتسجيل عمليات مخصصة
    public function logCustomAudit($action, $description, $oldValues = null, $newValues = null)
    {
        $this->logAudit($action, $description, $oldValues, $newValues);
    }
} 