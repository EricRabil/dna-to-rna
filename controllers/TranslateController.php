<?php

class TranslateController implements IController {

    private $model;
    private $bundle;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function main($params) {
      $dnatomrna = ['A' => 'U', 'T' => 'A', 'G' => 'C', 'C' => 'G'];
      $startcodon = 'AUG';
      $stopcodons = ['UAA', 'UAG', 'UGA'];
      $proteins = ['UUU' => 'phe', 'UUC' => 'phe', 'UUA' => 'leu', 'UUG' => 'leu', 'CUU' => 'leu', 'CUC' => 'leu', 'CUA' => 'leu', 'CUG' => 'leu',
          'AUU' => 'ile', 'AUC' => 'ile', 'AUA' => 'ile', 'AUG' => 'START', 'GUU' => 'val', 'GUC' => 'val', 'GUG' => 'val', 'GUA' => 'val',
          'UCU' => 'ser', 'UCC' => 'ser', 'UCA' => 'ser', 'UCG' => 'ser', 'CCU' => 'pro', 'CCA' => 'pro', 'CCG' => 'pro', 'CCC' => 'pro',
          'ACU' => 'thr', 'ACG' => 'thr', 'ACC' => 'thr', 'ACA' => 'thr', 'GCU' => 'ala', 'GCC' => 'ala', 'GCG' => 'ala', 'GCG' => 'ala',
          'UAU' => 'tyr', 'UAC' => 'tyr', 'UAA' => 'STOP', 'UAG' => 'STOP', 'CAU' => 'his', 'CAC' => 'his', 'CAG' => 'gln', 'AAU' => 'asn',
          'AAC' => 'asn', 'AAA' => 'lys', 'AAG' => 'lys', 'GAU' => 'asp', 'GAC' => 'asp', 'GAA' => 'glu', 'GAG' => 'glu', 'UGU' => 'cys',
          'UGC' => 'cys', 'UGA' => 'STOP', 'UGG' => 'trp', 'CGU' => 'arg', 'CGC' => 'arg', 'CGG' => 'arg', 'CGA' => 'arg', 'AGU' => 'ser',
          'AGC' => 'ser', 'AGA' => 'arg', 'AGG' => 'arg', 'GGU' => 'gly', 'GGG' => 'gly', 'GGC' => 'gly', 'GGA' => 'gly'];
      $dna = $_POST['dna'];
      $dna_split = explode('-', $dna);
      if(empty($dna_split)){
        $this->model->hasError = true;
        $this->model->errorText .= "The DNA sequence cannot be empty.<br />";
        $dna = 'TAC-ATC';
        $rna = 'AUG-UAG';
      }else{
        $rna = str_replace(array_keys($dnatomrna), array_values($dnatomrna), $dna);
      }
      $this->model->mrna = $rna;
      $this->model->dna = $dna;
      $split = explode('-', $rna);
      $proteinString = "";
      $started = false;
      foreach($split as $id => $codon){
        $clean = htmlspecialchars($codon);
        if($codon === $startcodon){
            $this->model->output .= "`".$clean."` is a START/MET codon. [mRNA/DNA Sequence ".$id."]<br />";
            if($started){
              $this->model->output .= "`".$clean."` is a start codon, but the protein sequence has already been started. [mRNA/DNA Sequence ".$id."]<br />";
            }
            $started = true;
            $proteinString .= $proteins[$codon].'-';
        }elseif(in_array($codon, $stopcodons) && $codon === end($split)){
            $this->model->output .= "`".$clean."` is a stop codon. [mRNA/DNA Sequence ".$id."]<br />";
            if(!$started){
              $this->model->output .= "`".$clean."` is a stop codon, but the protein sequence has not been started. [mRNA/DNA Sequence ".$id."]<br />";
            }
            $proteinString .= $proteins[$codon];
            $started = false;
        }elseif(in_array($codon, $stopcodons) && $codon != end($split)){
            $this->model->output .= "`".$clean."` is a stop codon. [mRNA/DNA Sequence ".$id."]<br />";
            $proteinString .= $proteins[$codon].'-';
        }elseif(!array_key_exists($codon, $proteins)){
            $this->model->hasError = true;
            $this->model->errorText .= "`".$clean."` is not a valid mRNA sequence (and cannot be translated to a protein.) It has been skipped. [mRNA/DNA Sequence ".$id."]<br />";
        }elseif($started && $codon === $startcodon){
            $this->model->output .= "`".$clean."` is a start codon but the sequence has already been started. [mRNA/DNA Sequence ".$id."]<br />";
            $proteinString .= $proteins[$codon].'-';
        }else{
            $this->model->output .= "`".$clean."` translates to a ".$proteins[$codon]." protein. [mRNA/DNA Sequence ".$id."]<br />";
            $proteinString .= $proteins[$codon].'-';
        }
      }

      $this->model->proteins = $proteinString;
    }

}
