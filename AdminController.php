<?php
/**
 * Created by Rasel Rana.
 * User: Rasel
 * Date: 2016-04-11
 * Time: 2:12 PM
 */

class AdminController extends \BaseController {

    /**
     * [spreadSheet manipulate spreadsheet data]
     * @return [array] [spreadsheet data]
     */
    public function spreadSheet() {
        
        $data = array();

        $spreadSheetId  = "1oz96L3kRhLww7CC-Ujb6oeCoXaPPJU4V1wcFtU3VqHg";

        $url            = "https://spreadsheets.google.com/feeds/list/". $spreadSheetId ."/od6/public/values?alt=json-in-script&callback=importGSS";
        $content        = @file_get_contents($url);
        $find           = '$t';

        $formated_data =  str_replace( $find, "gxcol", $content);

        $remove_importGSS =  str_replace("// API callback
importGSS({","{", $formated_data);

        $remove_end =  str_replace( "});", "}", $remove_importGSS);
   
        $googlespreadSheetData = json_decode($remove_end);

        if( array_key_exists('author',$googlespreadSheetData->feed ) ) {

            $titles     = array();
            $answerrow  = 0;

            foreach ($googlespreadSheetData->feed as $key=>$data) {

                if( $key == 'entry' ) {
                    
                    foreach ($data as $entryKey => $rowData) {

                        $answerrow = $answerrow+1;

                        if( array_key_exists('gsx$date', $rowData ) && array_key_exists('gsx$amountused', $rowData ) ) {
                            
                            foreach ($rowData as $key => $rdata) {

                                if( $key == 'gsx$date' ) {

                                    if( array_key_exists('gxcol', $rdata ) ) {
                                       
                                        if( !empty( $rdata->gxcol ) ) {

                                            $titles[$answerrow]['date'] = $rdata->gxcol;
                                        
                                        }
                                       
                                    }

                                } else if( $key == 'gsx$phonenumber' ) {

                                    if( array_key_exists('gxcol', $rdata ) ) {
                                       
                                        if( !empty( $rdata->gxcol ) ) {

                                            $titles[$answerrow]['phonenumber'] = $rdata->gxcol;

                                        }
                                       
                                    }

                                } else if( $key == 'gsx$amountused' ) {

                                    if( array_key_exists('gxcol', $rdata ) ) {
                                       
                                        if( !empty( $rdata->gxcol ) ) {
                                            
                                            $titles[$answerrow]["amountused"] = $rdata->gxcol;

                                        }
                                       
                                    }

                                } else if( $key == 'gsx$dailyamountused' ) {

                                    if( array_key_exists('gxcol', $rdata ) ) {
                                       
                                        if( !empty( $rdata->gxcol ) ) {
                                            
                                            $titles[$answerrow]["dailyamountused"] = $rdata->gxcol;

                                        }
                                       
                                    }

                                } else if( $key == 'gsx$dailyamountadjustedforreset' ) {

                                    if( array_key_exists('gxcol', $rdata ) ) {
                                       
                                        if( !empty( $rdata->gxcol ) ) {
                                            
                                            $titles[$answerrow]["dailyamountadjustedforreset"] = $rdata->gxcol;

                                        }
                                       
                                    }

                                } else if( $key == 'gsx$dailylitres' ) {

                                    if( array_key_exists('gxcol', $rdata ) ) {
                                       
                                        if( !empty( $rdata->gxcol ) ) {
                                            
                                            $titles[$answerrow]["dailylitres"]  = $rdata->gxcol;

                                        }
                                       
                                    }

                                } else if( $key == 'gsxgxcolotalamountinlitresday' ) {

                                    if( array_key_exists('gxcol', $rdata ) ) {
                                       
                                        if( !empty( $rdata->gxcol ) ) {
                                            
                                            $titles[$answerrow]["gsxgxcolotalamountinlitresday"] = $rdata->gxcol;

                                        }
                                       
                                    }

                                }

                            }


                        }


                    }

                }

            }
         
        }
    
        $data['process_result'] = $titles;

        return  view('spreadsheetData', $data); 
    }

}
