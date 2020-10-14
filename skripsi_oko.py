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
import time
auth = AutentikasiKBBI("zuttocool@gmail.com", "oko123oko")

app = Flask(__name__)
cors = CORS(app)
app.config['CORS_HEADERS'] = 'Content-Type'

factory = StemmerFactory()
stemmer = factory.create_stemmer()

def init(filepath):
    print(filepath)
    sentence = docx2txt.process(filepath)
    
    output   = stemmer.stem(sentence)
    output = list(output.split(' '))
    total_kata = len(output)
    
    
    spell = SpellChecker(language=None)
    spell2 = SpellChecker() # bahasa inggris
    
    spell.word_frequency.load_text_file('./katadasar.txt')
    
    misspelled = spell.unknown(output)
    misspelled2 = spell2.unknown(output)

    koreksi = list()
    keliru = list()
    
    masalah = list()
    masalah_baru = list()
    
    for word in misspelled:
        udah_diperiksa = False
        try:
            huk = KBBI(word, auth)
        except TidakDitemukan as e:
            huk = e.objek
            print(e)
            tampung_string = str(e)
            tampung_string = tampung_string.split(' tidak ditemukan')
            # masalah_baru.append(str(e))
            masalah_baru.append(tampung_string[0])
            masalah.append(str(huk))
            udah_diperiksa = True
    
        if spell2.correction(word) in misspelled2:
            keliru.append(spell2.correction(word))

        if not udah_diperiksa:
            koreksi.append(word)

    rekomendasi_koreksi = list()
    for kata in koreksi:
        rekomendasi_koreksi.append(spell.correction(kata))

    print(koreksi)
    total_kata_dokumen = len(sentence)
    dibuang = total_kata_dokumen - total_kata
    total_masalah = len(misspelled)
    total_kata_baku = total_kata - total_masalah
    
    return (total_kata_dokumen, total_kata, dibuang, total_kata_baku, total_masalah, masalah, masalah_baru, koreksi, rekomendasi_koreksi)
    
    

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
    start_time = time.time()

    content = request.get_json()
    print(content['lokasi'])

    (total_kata_dokumen, total_kata, dibuang, total_kata_baku, total_masalah, masalah, masalah_baru, koreksi, rekomendasi_koreksi) = init(content['lokasi'])
    text1 = 'total kata pada dokumen :' + str(total_kata_dokumen) + 'kata \n'
    text2 = 'total kata yang sudah distemming :' + str(total_kata) + 'kata \n'
    
    total_waktu_eksekusi = time.time() - start_time
    print(text1);
    print(text2);
    print('total kata atau simbol yang tidak penting :', dibuang)
    print('total kata baku :', total_kata_baku, 'kata')
    print('total kata tidak baku :', total_masalah, 'kata')
    print('kata tidak baku :', masalah)
    #print('kata masalah baru :', masalah_baru)
    print('total waktu eksekusi :', total_waktu_eksekusi, 'detik')
    print('=======================================================')
    print('kata tidak baku bisa jadi berupa nama orang atau merek!')
    result = {'total_kata_dokumen': total_kata_dokumen, 'total_kata': total_kata, 'dibuang': dibuang, 'total_kata_baku': total_kata_baku, 'total_masalah': total_masalah, 'masalah_baru': masalah_baru, 'masalah': masalah, 'total_waktu_eksekusi': total_waktu_eksekusi, 'koreksi': koreksi, 'rekomendasi_koreksi': rekomendasi_koreksi}

    return jsonify(result)

 

