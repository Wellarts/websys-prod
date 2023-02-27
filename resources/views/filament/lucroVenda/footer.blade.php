
 <table @class("border border-gray-300 w-full text-right table-auto font-bold bg-stone-400")>

    <tr>
        <td></td>
        <td class="filament-tables-cell text-2xl text-left">
              Resumo:
       </td>

            <td class="filament-tables-cell text-bg" alignment="right">

                    Valor Total Vendido: R$ {{$this->getTableRecords()->sum('valor_total')}} <br>
                    Lucro Total: R$ {{ ($this->getTableRecords()->sum('valor_total')) - $this->getTableRecords()->sum('itens_venda_sum_valor_custo_atual') }} <br>


            </td>
            <td></td>

    </tr>

</table>


