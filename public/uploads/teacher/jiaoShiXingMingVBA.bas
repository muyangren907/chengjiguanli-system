Attribute VB_Name = "ģ��1"
'�ڶ�����������:
'0--����ƴ��(���ִ�д)
'1--����Сдƴ��
'2--���ش�дƴ��
'3--����Сдƴ������ĸ
'4--���ش�дƴ������ĸ


Public Function Chinese2Spell(sChinese As String, Optional iflag As Integer = 0) As String
'ժ�ԣ�http://www.csdn.com.cn
Dim C2S As String
Set d = CreateObject("Scripting.Dictionary")
d.Add "a", -20319
d.Add "ai", -20317
d.Add "an", -20304
d.Add "ang", -20295
d.Add "ao", -20292
d.Add "ba", -20283
d.Add "bai", -20265
d.Add "ban", -20257
d.Add "bang", -20242
d.Add "bao", -20230
d.Add "bei", -20051
d.Add "ben", -20036
d.Add "beng", -20032
d.Add "bi", -20026
d.Add "bian", -20002
d.Add "biao", -19990
d.Add "bie", -19986
d.Add "bin", -19982
d.Add "bing", -19976
d.Add "bo", -19805
d.Add "bu", -19784
d.Add "ca", -19775
d.Add "cai", -19774
d.Add "can", -19763
d.Add "cang", -19756
d.Add "cao", -19751
d.Add "ce", -19746
d.Add "ceng", -19741
d.Add "cha", -19739
d.Add "chai", -19728
d.Add "chan", -19725
d.Add "chang", -19715
d.Add "chao", -19540
d.Add "che", -19531
d.Add "chen", -19525
d.Add "cheng", -19515
d.Add "chi", -19500
d.Add "chong", -19484
d.Add "chou", -19479
d.Add "chu", -19467
d.Add "chuai", -19289
d.Add "chuan", -19288
d.Add "chuang", -19281
d.Add "chui", -19275
d.Add "chun", -19270
d.Add "chuo", -19263
d.Add "ci", -19261
d.Add "cong", -19249
d.Add "cou", -19243
d.Add "cu", -19242
d.Add "cuan", -19238
d.Add "cui", -19235
d.Add "cun", -19227
d.Add "cuo", -19224
d.Add "da", -19218
d.Add "dai", -19212
d.Add "dan", -19038
d.Add "dang", -19023
d.Add "dao", -19018
d.Add "de", -19006
d.Add "deng", -19003
d.Add "di", -18996
d.Add "dian", -18977
d.Add "diao", -18961
d.Add "die", -18952
d.Add "ding", -18783
d.Add "diu", -18774
d.Add "dong", -18773
d.Add "dou", -18763
d.Add "du", -18756
d.Add "duan", -18741
d.Add "dui", -18735
d.Add "dun", -18731
d.Add "duo", -18722
d.Add "e", -18710
d.Add "en", -18697
d.Add "er", -18696
d.Add "fa", -18526
d.Add "fan", -18518
d.Add "fang", -18501
d.Add "fei", -18490
d.Add "fen", -18478
d.Add "feng", -18463
d.Add "fo", -18448
d.Add "fou", -18447
d.Add "fu", -18446
d.Add "ga", -18239
d.Add "gai", -18237
d.Add "gan", -18231
d.Add "gang", -18220
d.Add "gao", -18211
d.Add "ge", -18201
d.Add "gei", -18184
d.Add "gen", -18183
d.Add "geng", -18181
d.Add "gong", -18012
d.Add "gou", -17997
d.Add "gu", -17988
d.Add "gua", -17970
d.Add "guai", -17964
d.Add "guan", -17961
d.Add "guang", -17950
d.Add "gui", -17947
d.Add "gun", -17931
d.Add "guo", -17928
d.Add "ha", -17922
d.Add "hai", -17759
d.Add "han", -17752
d.Add "hang", -17733
d.Add "hao", -17730
d.Add "he", -17721
d.Add "hei", -17703
d.Add "hen", -17701
d.Add "heng", -17697
d.Add "hong", -17692
d.Add "hou", -17683
d.Add "hu", -17676
d.Add "hua", -17496
d.Add "huai", -17487
d.Add "huan", -17482
d.Add "huang", -17468
d.Add "hui", -17454
d.Add "hun", -17433
d.Add "huo", -17427
d.Add "ji", -17417
d.Add "jia", -17202
d.Add "jian", -17185
d.Add "jiang", -16983
d.Add "jiao", -16970
d.Add "jie", -16942
d.Add "jin", -16915
d.Add "jing", -16733
d.Add "jiong", -16708
d.Add "jiu", -16706
d.Add "ju", -16689
d.Add "juan", -16664
d.Add "jue", -16657
d.Add "jun", -16647
d.Add "ka", -16474
d.Add "kai", -16470
d.Add "kan", -16465
d.Add "kang", -16459
d.Add "kao", -16452
d.Add "ke", -16448
d.Add "ken", -16433
d.Add "keng", -16429
d.Add "kong", -16427
d.Add "kou", -16423
d.Add "ku", -16419
d.Add "kua", -16412
d.Add "kuai", -16407
d.Add "kuan", -16403
d.Add "kuang", -16401
d.Add "kui", -16393
d.Add "kun", -16220
d.Add "kuo", -16216
d.Add "la", -16212
d.Add "lai", -16205
d.Add "lan", -16202
d.Add "lang", -16187
d.Add "lao", -16180
d.Add "le", -16171
d.Add "lei", -16169
d.Add "leng", -16158
d.Add "li", -16155
d.Add "lia", -15959
d.Add "lian", -15958
d.Add "liang", -15944
d.Add "liao", -15933
d.Add "lie", -15920
d.Add "lin", -15915
d.Add "ling", -15903
d.Add "liu", -15889
d.Add "long", -15878
d.Add "lou", -15707
d.Add "lu", -15701
d.Add "lv", -15681
d.Add "luan", -15667
d.Add "lue", -15661
d.Add "lun", -15659
d.Add "luo", -15652
d.Add "ma", -15640
d.Add "mai", -15631
d.Add "man", -15625
d.Add "mang", -15454
d.Add "mao", -15448
d.Add "me", -15436
d.Add "mei", -15435
d.Add "men", -15419
d.Add "meng", -15416
d.Add "mi", -15408
d.Add "mian", -15394
d.Add "miao", -15385
d.Add "mie", -15377
d.Add "min", -15375
d.Add "ming", -15369
d.Add "miu", -15363
d.Add "mo", -15362
d.Add "mou", -15183
d.Add "mu", -15180
d.Add "na", -15165
d.Add "nai", -15158
d.Add "nan", -15153
d.Add "nang", -15150
d.Add "nao", -15149
d.Add "ne", -15144
d.Add "nei", -15143
d.Add "nen", -15141
d.Add "neng", -15140
d.Add "ni", -15139
d.Add "nian", -15128
d.Add "niang", -15121
d.Add "niao", -15119
d.Add "nie", -15117
d.Add "nin", -15110
d.Add "ning", -15109
d.Add "niu", -14941
d.Add "nong", -14937
d.Add "nu", -14933
d.Add "nv", -14930
d.Add "nuan", -14929
d.Add "nue", -14928
d.Add "nuo", -14926
d.Add "o", -14922
d.Add "ou", -14921
d.Add "pa", -14914
d.Add "pai", -14908
d.Add "pan", -14902
d.Add "pang", -14894
d.Add "pao", -14889
d.Add "pei", -14882
d.Add "pen", -14873
d.Add "peng", -14871
d.Add "pi", -14857
d.Add "pian", -14678
d.Add "piao", -14674
d.Add "pie", -14670
d.Add "pin", -14668
d.Add "ping", -14663
d.Add "po", -14654
d.Add "pu", -14645
d.Add "qi", -14630
d.Add "qia", -14594
d.Add "qian", -14429
d.Add "qiang", -14407
d.Add "qiao", -14399
d.Add "qie", -14384
d.Add "qin", -14379
d.Add "qing", -14368
d.Add "qiong", -14355
d.Add "qiu", -14353
d.Add "qu", -14345
d.Add "quan", -14170
d.Add "que", -14159
d.Add "qun", -14151
d.Add "ran", -14149
d.Add "rang", -14145
d.Add "rao", -14140
d.Add "re", -14137
d.Add "ren", -14135
d.Add "reng", -14125
d.Add "ri", -14123
d.Add "rong", -14122
d.Add "rou", -14112
d.Add "ru", -14109
d.Add "ruan", -14099
d.Add "rui", -14097
d.Add "run", -14094
d.Add "ruo", -14092
d.Add "sa", -14090
d.Add "sai", -14087
d.Add "san", -14083
d.Add "sang", -13917
d.Add "sao", -13914
d.Add "se", -13910
d.Add "sen", -13907
d.Add "seng", -13906
d.Add "sha", -13905
d.Add "shai", -13896
d.Add "shan", -13894
d.Add "shang", -13878
d.Add "shao", -13870
d.Add "she", -13859
d.Add "shen", -13847
d.Add "sheng", -13831
d.Add "shi", -13658
d.Add "shou", -13611
d.Add "shu", -13601
d.Add "shua", -13406
d.Add "shuai", -13404
d.Add "shuan", -13400
d.Add "shuang", -13398
d.Add "shui", -13395
d.Add "shun", -13391
d.Add "shuo", -13387
d.Add "si", -13383
d.Add "song", -13367
d.Add "sou", -13359
d.Add "su", -13356
d.Add "suan", -13343
d.Add "sui", -13340
d.Add "sun", -13329
d.Add "suo", -13326
d.Add "ta", -13318
d.Add "tai", -13147
d.Add "tan", -13138
d.Add "tang", -13120
d.Add "tao", -13107
d.Add "te", -13096
d.Add "teng", -13095
d.Add "ti", -13091
d.Add "tian", -13076
d.Add "tiao", -13068
d.Add "tie", -13063
d.Add "ting", -13060
d.Add "tong", -12888
d.Add "tou", -12875
d.Add "tu", -12871
d.Add "tuan", -12860
d.Add "tui", -12858
d.Add "tun", -12852
d.Add "tuo", -12849
d.Add "wa", -12838
d.Add "wai", -12831
d.Add "wan", -12829
d.Add "wang", -12812
d.Add "wei", -12802
d.Add "wen", -12607
d.Add "weng", -12597
d.Add "wo", -12594
d.Add "wu", -12585
d.Add "xi", -12556
d.Add "xia", -12359
d.Add "xian", -12346
d.Add "xiang", -12320
d.Add "xiao", -12300
d.Add "xie", -12120
d.Add "xin", -12099
d.Add "xing", -12089
d.Add "xiong", -12074
d.Add "xiu", -12067
d.Add "xu", -12058
d.Add "xuan", -12039
d.Add "xue", -11867
d.Add "xun", -11861
d.Add "ya", -11847
d.Add "yan", -11831
d.Add "yang", -11798
d.Add "yao", -11781
d.Add "ye", -11604
d.Add "yi", -11589
d.Add "yin", -11536
d.Add "ying", -11358
d.Add "yo", -11340
d.Add "yong", -11339
d.Add "you", -11324
d.Add "yu", -11303
d.Add "yuan", -11097
d.Add "yue", -11077
d.Add "yun", -11067
d.Add "za", -11055
d.Add "zai", -11052
d.Add "zan", -11045
d.Add "zang", -11041
d.Add "zao", -11038
d.Add "ze", -11024
d.Add "zei", -11020
d.Add "zen", -11019
d.Add "zeng", -11018
d.Add "zha", -11014
d.Add "zhai", -10838
d.Add "zhan", -10832
d.Add "zhang", -10815
d.Add "zhao", -10800
d.Add "zhe", -10790
d.Add "zhen", -10780
d.Add "zheng", -10764
d.Add "zhi", -10587
d.Add "zhong", -10544
d.Add "zhou", -10533
d.Add "zhu", -10519
d.Add "zhua", -10331
d.Add "zhuai", -10329
d.Add "zhuan", -10328
d.Add "zhuang", -10322
d.Add "zhui", -10315
d.Add "zhun", -10309
d.Add "zhuo", -10307
d.Add "zi", -10296
d.Add "zong", -10281
d.Add "zou", -10274
d.Add "zu", -10270
d.Add "zuan", -10262
d.Add "zui", -10260
d.Add "zun", -10256
d.Add "zuo", -10254
num = Asc(sChinese)
a = d.Items
b = d.keys
Application.Volatile
For l = 1 To Len(sChinese)
    num = Asc(Mid(sChinese, l, 1))
    For i = d.Count - 1 To 0 Step -1
        If a(i) <= num Then Exit For
    Next
    Select Case iflag
    Case 0 '����ƴ��(���ִ�д)
        C2S = C2S & Application.WorksheetFunction.Proper(b(i))
    Case 1 '����Сдƴ��
        C2S = C2S & b(i)
    Case 2 '���ش�дƴ��
        C2S = C2S & UCase$(b(i))
    Case 3 '����Сдƴ������
        C2S = C2S & Left$(b(i), 1)
    Case 4 '���ش�дƴ������
        C2S = C2S & UCase$(Left$(b(i), 1))
    End Select
    If Len(sChinese) > 1 And iflag < 3 Then C2S = C2S & " "
Next
Chinese2Spell = C2S
Set d = Nothing
End Function

