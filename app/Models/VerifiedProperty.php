<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

class VerifiedProperty extends Model
{
    private $extensions = ['png', 'jpg', 'jpeg', 'jfif'];

    protected $table = 'backoffice_verified_property';

    protected $fillable = [
        'id',
        'property_id',
        'user_document',
        'user_confirmation',
        'document',
        'relation',
        'verified',
        'reason'
    ];

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }

    private function setFile(Request $request, $fileName, $name, $fieldName)
    {
        if (!$request->hasFile($fileName)) {
            return back()->withErrors([
                "$fileName" => "O(A) $name é obrigatório(a), verifique os anexos e tente novamente."
            ]);
        }

        $document = $request->file($fileName);

        if (!in_array($document->getClientOriginalExtension(), $this->extensions))
            return back()->withErrors([
                "$fileName" => "O(A) $name informado(a) não é de um tipo válido."
            ]);

        $documentWithExt = $document->getClientOriginalName();
        $fileDocument = pathinfo($documentWithExt, PATHINFO_FILENAME);
        $fileNameDocument = $fileDocument . '_' . time() . '.' . $document->getClientOriginalExtension();
        $document->storeAs('documents', $fileNameDocument);
        $this->setAttribute($fieldName, $fileNameDocument);
    }

    public function setUserDocument(Request $request)
    {
        $this->setFile($request, 'document', 'Documento', 'user_document');
    }

    public function setUserConfirmation(Request $request)
    {
        $this->setFile($request, 'confirmation', 'Confirmação', 'user_confirmation');
    }

    public function setPropertyDocument(Request $request)
    {
        $this->setFile($request, 'residence', 'Comprovante de Residência', 'document');
    }

    public function setPropertyRelation(Request $request)
    {
        if ($request->hasFile('relation')) {
            $relation = $request->file('relation');

            if (!in_array($relation->getClientOriginalExtension(), $this->extensions))
                return back()->withErrors([
                    'relation' => 'O Comprovante de Vínculo informado não é de um tipo válido.',
                ]);

            $confirmationWithExt = $relation->getClientOriginalName();
            $fileConfirmation = pathinfo($confirmationWithExt, PATHINFO_FILENAME);
            $fileNameRelation = $fileConfirmation . '_' . time() . '.' . $relation->getClientOriginalExtension();
            $relation->storeAs('documents', $fileNameRelation);
            $this->setAttribute('relation', $fileNameRelation);
        }
    }
}
