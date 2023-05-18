

<div class="grid grid-cols-6 border-2 text-lg">
  <div class="col-start-1 col-span-4 ">TOTAL</div>
  <div class="col-start-2 col-end-3  text-center"> R$ {{number_format(($this->getTableRecords()->sum('valor_total')),2, ",", ".")}}</div>
  <div class="col-start-3 col-end-4  text-center"> R$ {{number_format(($this->getTableRecords()->sum('valor_total')) - $this->getTableRecords()->sum('itens_venda_sum_total_custo_atual'),2, ",", ".")}}</div>

</div>


