using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Text.RegularExpressions;

namespace BaseDTO
{
    public class Lead_Answers
    {
        public List<DTO_Dict> Bdisctrict { get; set; }
        public List<DTO_Dict> Childrens { get; set; }
        public List<DTO_Dict> Family { get; set; }
        public List<DTO_Dict> Family_unempl { get; set; }
        public List<DTO_Dict> Migrant { get; set; }
        public List<DTO_Dict> Reason { get; set; }
        public List<DTO_Dict> House { get; set; }
    }
    public class DTO_Lead_Reg: IDataErrorInfo
    {
        public string Fio { get; set; }
        public string Phone { get; set; }
        public string Email { get; set; }
        public int IdReason { get; set; }
        public string FioNeed { get; set; }
        public string City { get; set; }
        public string District { get; set; }
        public int IdTypeOfHouse { get; set; }
        public int IdBdistrict { get; set; }
        public int IdMigrant { get; set; }
        public int IdFamUnemp { get; set; }
        public sbyte Income { get; set; }
        public int IdFamily { get; set; }
        public int IdChild { get; set; }
        public sbyte Adopted { get; set; }
        public string Categories { get; set; }
        public string Need { get; set; }
        public sbyte Volunteer { get; set; }
        public string Subcontact { get; set; }
        public DateTime Datelead { get; set; }


        public string Error
        {
            get;
            set;
        }

        public string this[string columnName]
        {
            get
            {
                this.Error = String.Empty;
                switch (columnName)
                {
                    case "Fio":
                        if (String.IsNullOrEmpty(Fio))
                        {
                            return this.Error = "Укажите имя представителя";
                        }
                        else
                        {
                            if (!Regex.IsMatch(Fio, @"^[\p{L}\p{M}' \.\-]+$"))
                                return this.Error = "Ошибка в имени представителя";
                        }
                        break;
                    case "Phone":
                        if (String.IsNullOrEmpty(Phone))
                        {
                            return this.Error = "Укажите номер";
                        }
                        else
                        {
                            if (!Regex.IsMatch(Phone, @"^\(?([0-9]{3})\)?[-.●]?([0-9]{3})[-.●]?([0-9]{4})$"))
                                return this.Error = "Неправильный телефон";
                        }
                        break;
                    case "Email":
                        if (String.IsNullOrEmpty(Email))
                        {
                            return this.Error = "Укажите почту";
                        }
                        else
                        {
                            if (!Regex.IsMatch(Email, @"^[\w!#$%&'*+\-/=?\^_`{|}~]+(\.[\w!#$%&'*+\-/=?\^_`{|}~]+)*" + "@" + @"((([\-\w]+\.)+[a-zA-Z]{2,4})|(([0-9]{1,3}\.){3}[0-9]{1,3}))$"))
                                return this.Error = "Ошибка в почте";
                        }
                        break;
                    case "IdReason":
                        if (IdReason == 0)
                            return this.Error = "Выберите цель заявления";
                        break;
                    case "FioNeed":
                        if (String.IsNullOrEmpty(FioNeed))
                        {
                            return this.Error = "Укажите ФИО нуждающегося";
                        }
                        else
                        {
                            if (!Regex.IsMatch(FioNeed, @"^([a-zA-Z]*)\s+([a-zA-Z ]*)$"))
                                return this.Error = "Ошибка в имени нуждающегося";
                        }
                        break;
                    case "City":
                        if (String.IsNullOrEmpty(City))
                        {
                            return this.Error = "Укажите город";
                        }
                        else
                        {
                            if (!Regex.IsMatch(City, @"^([a-zA-Z]*)$"))
                                return this.Error = "Ошибка в введенном городе";
                        }
                        break;
                    case "District":
                        if (String.IsNullOrEmpty(District))
                        {
                            return this.Error = "Укажите район";
                        }
                        else
                        {
                            if (!Regex.IsMatch(District, @"^[a-zA-Z]+$"))
                                return this.Error = "Ошибка в введенном районе";
                        }
                        break;
                    case "IdTypeOfHouse":
                        if (IdTypeOfHouse == 0)
                            return this.Error = "Выберите тип дома";
                        break;
                    case "IdBdistrict":
                        if (IdBdistrict==0)
                            return this.Error = "Выберите подвергался ли район обстрелу";
                        break;
                    case "IdMigrant":
                        if (IdMigrant == 0)
                            return this.Error = "Выберите переселенец или нет";
                        break;
                    case "IdFamUnemp":
                        if (IdFamUnemp==0)
                            return this.Error = "Выберите есть ли трудоспособные";
                        break;
                    case "IdFamily":
                        if (IdFamily == 0)
                            return this.Error = "Выберите полная семья или нет";
                        break;
                    case "IdChild":
                        if (IdChild == 0)
                            return this.Error = "Выберите есть ли несовершеннолетние";
                        break;
                    case "Subcontact":
                        if (String.IsNullOrEmpty(Subcontact) || String.IsNullOrWhiteSpace(Subcontact))
                            return this.Error = "Добавьте контакты с нуждающимся";
                        break;
                    default:
                        {
                            return this.Error = "Ok";
                        }
                }
                return this.Error;
            }
        }


    }

    public class DTO_Lead_Get
    {
        public int Id { get; set; }
        public string Fio { get; set; }
        public string Phone { get; set; }
        public string Email { get; set; }
        public string FioNeed { get; set; }
        public string City { get; set; }
        public string District { get; set; }
        public sbyte Income { get; set; }
        public sbyte Adopted { get; set; }
        public string Categories { get; set; }
        public string Need { get; set; }
        public sbyte Volunteer { get; set; }
        public string Subcontact { get; set; }
        public DateTime Datelead { get; set; }

        public DTO_Dict IdBdistrictNavigation { get; set; }
        public DTO_Dict IdChildNavigation { get; set; }
        public DTO_Dict IdFamUnempNavigation { get; set; }
        public DTO_Dict IdFamilyNavigation { get; set; }
        public DTO_Dict IdMigrantNavigation { get; set; }
        public DTO_Dict IdReasonNavigation { get; set; }
        public DTO_Dict IdTypeOfHouseNavigation { get; set; }

    }

}
