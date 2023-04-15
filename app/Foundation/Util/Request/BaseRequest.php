<?php

namespace App\Foundation\Util\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class BaseRequest extends FormRequest
{
    /**
     * @var string|null 当前路由名称
     */
    protected $routeName;

    /**
     * @var array 规则
     */
    protected array $rules;

    /**
     * @var array 提示信息
     */
    protected array $messages;

    public function __construct()
    {
        parent::__construct();
        $this->routeName = Route::currentRouteName();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->rules[$this->routeName] ?? [];
    }

    public function messages()
    {
        return $this->messages[$this->routeName] ?? [];
    }
}
