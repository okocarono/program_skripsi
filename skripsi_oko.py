# -*- coding: utf-8 -*-
"""
Created on Thu Jun 25 16:06:38 2020

@author: oko carono
"""

import docx2txt
from spellchecker import SpellChecker
from kbbi import KBBI
from kbbi import  AutentikasiKBBI
from kbbi import TidakDitemukan
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
from flask import Flask, jsonify, request
from flask_cors import CORS, cross_origin

app = Flask(__name__)
cors = CORS(app)
app.config['CORS_HEADERS'] = 'Content-Type'

# create stemmer
factory = StemmerFactory()
stemmer = factory.create_stemmer()
    
# stem
#sentence = docx2txt.process("latarbelakang.docx")

def init(filepath):
    #sentence = docx2txt.process("C:/xampp/htdocs/stemming_naziefadriani/dokumen/Bab_21.docx")
    print(filepath)
    sentence = docx2txt.process(filepath)
    
    output   = stemmer.stem(sentence)
    output = list(output.split(' '))
    total_kata = len(output)
    
    # kalo pengen liat isi dari variabel output hilangkan pagar di bawah ini
    # output
    
    spell = SpellChecker(language=None)
    spell2 = SpellChecker()   
    
    spell.word_frequency.load_text_file('./katadasar.txt')
    
    misspelled = spell.unknown(output)
    misspelled2 = spell2.unknown(output)

    koreksi = list()
    keliru = list()
    
    for word in misspelled:
      #print(spell.correction(word))
    
        if spell2.correction(word) in misspelled2:
            keliru.append(spell2.correction(word))
        #print('keliru')
        #print(spell2.correction(word))
        koreksi.append(spell.correction(word))
  
      #print (word)
      #print()
      #print(spell.candidates(word))
      
    auth = AutentikasiKBBI("zuttocool@gmail.com", "oko123oko")
    # roh = KBBI("ikan", auth)
    
    masalah = list()
    masalah_baru = list()
    for k in koreksi:
      try:
        huk = KBBI(k, auth)
      except TidakDitemukan as e:
        huk = e.objek
        print(e)
        masalah_baru.append(str(e))
        masalah.append(str(huk))
    
      #print(huk)
      
    total_kata_dokumen = len(sentence)
    dibuang = total_kata_dokumen - total_kata
    total_masalah = len(masalah)
    total_kata_baku = total_kata - total_masalah
    
    return (total_kata_dokumen, total_kata, dibuang, total_kata_baku, total_masalah, masalah, masalah_baru)
    
    

@app.route('/')
def salam():
    return 'Selamat Datang Di Pencarian Kata Baku Dan Tidak Baku'

@cross_origin()
@app.route('/testing', methods=['POST'])
def test():
    content = request.get_json()
    print(type(content))
    print(content['id'])
    print(content['lokasi'])
    return 'coba dulu gan'

@cross_origin()
@app.route('/index', methods=['POST'])
def index():
    content = request.get_json()
    print(content['lokasi'])

    (total_kata_dokumen, total_kata, dibuang, total_kata_baku, total_masalah, masalah, masalah_baru) = init(content['lokasi'])
    text1 = 'total kata pada dokumen :' + str(total_kata_dokumen) + 'kata \n'
    text2 = 'total kata yang sudah distemming :' + str(total_kata) + 'kata \n'
    
    print(text1);
    print(text2);
    print('total kata atau simbol yang tidak penting :', dibuang)
    print('total kata baku :', total_kata_baku, 'kata')
    print('total kata tidak baku :', total_masalah, 'kata')
    print('kata tidak baku :', masalah)
    print('=======================================================')
    print('kata tidak baku bisa jadi berupa nama orang atau merek!')
    result = {'total_kata_dokumen': total_kata_dokumen, 'total_kata': total_kata, 'dibuang': dibuang, 'total_kata_baku': total_kata_baku, 'total_masalah': total_masalah, 'masalah_baru': masalah_baru}

    return jsonify(result)

 

