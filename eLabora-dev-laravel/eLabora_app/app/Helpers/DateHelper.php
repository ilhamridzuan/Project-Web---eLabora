<?php

/**
 * DateHelper - Helper functions untuk formatting tanggal dan waktu
 * 
 * Format standar: "31 Desember 2025, 14:30 WIB"
 * Timezone: Asia/Jakarta (WIB)
 */

use Carbon\Carbon;

if (!function_exists('formatDateTime')) {
    /**
     * Format tanggal dan waktu lengkap
     * 
     * @param string|null $date
     * @return string Format: "31 Desember 2025, 14:30 WIB"
     */
    function formatDateTime($date)
    {
        if (empty($date)) {
            return '-';
        }

        try {
            return Carbon::parse($date)
                ->timezone('Asia/Jakarta')
                ->translatedFormat('d F Y, H:i') . ' WIB';
        } catch (\Exception $e) {
            return '-';
        }
    }
}

if (!function_exists('formatDate')) {
    /**
     * Format tanggal saja (tanpa waktu)
     * 
     * @param string|null $date
     * @return string Format: "31 Desember 2025"
     */
    function formatDate($date)
    {
        if (empty($date)) {
            return '-';
        }

        try {
            return Carbon::parse($date)
                ->timezone('Asia/Jakarta')
                ->translatedFormat('d F Y');
        } catch (\Exception $e) {
            return '-';
        }
    }
}

if (!function_exists('formatTime')) {
    /**
     * Format waktu saja (tanpa tanggal)
     * 
     * @param string|null $date
     * @return string Format: "14:30 WIB"
     */
    function formatTime($date)
    {
        if (empty($date)) {
            return '-';
        }

        try {
            return Carbon::parse($date)
                ->timezone('Asia/Jakarta')
                ->format('H:i') . ' WIB';
        } catch (\Exception $e) {
            return '-';
        }
    }
}

if (!function_exists('formatDateShort')) {
    /**
     * Format tanggal pendek
     * 
     * @param string|null $date
     * @return string Format: "31 Des 2025"
     */
    function formatDateShort($date)
    {
        if (empty($date)) {
            return '-';
        }

        try {
            return Carbon::parse($date)
                ->timezone('Asia/Jakarta')
                ->translatedFormat('d M Y');
        } catch (\Exception $e) {
            return '-';
        }
    }
}

if (!function_exists('formatRelative')) {
    /**
     * Format tanggal relatif (human readable)
     * 
     * @param string|null $date
     * @return string Format: "2 jam yang lalu", "Kemarin", dll
     */
    function formatRelative($date)
    {
        if (empty($date)) {
            return '-';
        }

        try {
            Carbon::setLocale('id');
            return Carbon::parse($date)
                ->timezone('Asia/Jakarta')
                ->diffForHumans();
        } catch (\Exception $e) {
            return '-';
        }
    }
}

if (!function_exists('formatDateTimeShort')) {
    /**
     * Format tanggal dan waktu pendek
     * 
     * @param string|null $date
     * @return string Format: "31 Des 2025, 14:30"
     */
    function formatDateTimeShort($date)
    {
        if (empty($date)) {
            return '-';
        }

        try {
            return Carbon::parse($date)
                ->timezone('Asia/Jakarta')
                ->translatedFormat('d M Y, H:i');
        } catch (\Exception $e) {
            return '-';
        }
    }
}
