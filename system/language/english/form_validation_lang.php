<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']		= '{field} tidak boleh kosong.';
$lang['form_validation_isset']			= '{field} harus di isikan.';
$lang['form_validation_valid_email']		= '{field} alamat email harus lengkap.';
$lang['form_validation_valid_emails']		= 'The {field} semua alamat email harus lengkap.';
$lang['form_validation_valid_url']		= ' {field} bidang harus URL valid.';
$lang['form_validation_valid_ip']		= ' {field} bidang harus IP valid.';
$lang['form_validation_min_length']		= ' {field} bidang harus paling panjang {param} karakter.';
$lang['form_validation_max_length']		= ' {field} panjangnya tidak boleh melebihi  {param} karakter.';
$lang['form_validation_exact_length']		= ' {field} panjangnya harus tepat {param} karakter.';
$lang['form_validation_alpha']			= ' {field} bidang hanya boleh berisikan karakter alphabet.';
$lang['form_validation_alpha_numeric']		= ' {field} bidang hanya boleh berisikan karakter alpha-numeric .';
$lang['form_validation_alpha_numeric_spaces']	= ' {field} field may only contain alpha-numeric characters and spaces.';
$lang['form_validation_alpha_dash']		= ' {field} bidang hanya berisikan alpha-numeric characters, underscores, and dashes.';
$lang['form_validation_numeric']		= ' {field} bidang harus berisikan  numbers.';
$lang['form_validation_is_numeric']		= ' {field} bidang harus berisikan  characters numeric .';
$lang['form_validation_integer']		= ' {field} bidang harus berisikan integer.';
$lang['form_validation_regex_match']		= ' {field} bidang isian tidak sesuai format.';
$lang['form_validation_matches']		= ' {field} tidak sama dengan {param}.';
$lang['form_validation_differs']		= ' {field} tidak cocok dengan {param}.';
$lang['form_validation_is_unique'] 		= ' {field} sudah terdaftar.';
$lang['form_validation_is_natural']		= ' {field} harus berisikan angka.';
$lang['form_validation_is_natural_no_zero']	= ' {field} bidang hanya boleh berisi angka dan harus lebih besar dari nol.';
$lang['form_validation_decimal']		= ' {field} harus berisikan angka desimal';
$lang['form_validation_less_than']		= ' {field} bidang harus mengandung angka kurang dari {param}.';
$lang['form_validation_less_than_equal_to']	= ' {field} bidang harus mengandung angka kurang dari atau sama dengan {param}.';
$lang['form_validation_greater_than']		= ' {field} bidang harus mengandung angka lebih besar dari {param}.';
$lang['form_validation_greater_than_equal_to']	= ' {field} bidang harus mengandung angka lebih besar dari atau sama dengan {param}.';
$lang['form_validation_error_message_not_set']	= 'Tidak dapat mengakses pesan kesalahan yang sesuai dengan nama bidang {field}.';
$lang['form_validation_in_list']		= ' {field} bidang harus salah satu dari: {param}.';
