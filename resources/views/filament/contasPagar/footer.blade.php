
 <table @class("border border-gray-300 w-full text-right table-auto font-bold bg-stone-400")>

    <tr>
        <td></td>
        <td class="filament-tables-cell text-2xl text-left">
              Resumo:
       </td>

            <td class="filament-tables-cell text-bg" alignment="right">

                    Valor das Parcelas: R$ {{($this->getTableRecords()->sum('valor_parcela')) }} <br>
                    Valor Pago: R$ {{($this->getTableRecords()->sum('valor_recebido')) }} <br>
                    ____________________ <br>
                    Saldo: R$  {{($this->getTableRecords()->sum('valor_recebido')) - ($this->getTableRecords()->sum('valor_parcela')) }}

            </td>
            <td></td>

    </tr>

</table>


