using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.model;
using BaseDTO;
using Newtonsoft.Json;
namespace BaseDDC.Controllers
{
    [Route("Profile")]
    [ApiController]
    public class ProfileController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();
        [Route("GetById/{id}")]
        [HttpPost]
        public IActionResult GetId([FromBody] DTO_Auth_Obj auth, int id)
        {
            try
            {
                Profile profile = _context.Profile.
                  Where(x => x.Id == id).
                  Include(x => x.IdPeopleNavigation).
                     ThenInclude(x => x.IdCityNavigation).
                  Include(x => x.IdPeopleNavigation).
                      ThenInclude(x => x.IdGenderNavigation).
                  Include(x => x.IdTypeHeatingNavigation).
                  Include(x => x.IdTypeOfHouseNavigation).
                  Include(x => x.Crosscategory).
                  Include(x => x.Crossneed).
                  Include(x => x.Crosstraining).
                  Include(x=>x.Help)
                    .ThenInclude(xx=>xx.IdProjectNavigation).
                  Include(x=>x.Help).
                    ThenInclude(xx=>xx.IdDonorNavigation).
                  Include(x=>x.Help).
                    ThenInclude(xx=>xx.IdHelptypeNavigation).
                  FirstOrDefault();
                DTO_Profile_Get result = AutoMapper.Mapper.Map<Profile, DTO_Profile_Get>(profile);
                return Ok(result);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
        [HttpPost]
        [Route("UpdateCategory")]
        public IActionResult UpdateCategory([FromBody]DTO_Auth_Obj t)
        {
            Update upd;
            try
            {
                upd = JsonConvert.DeserializeObject<Update>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удалось распознать полученный объект");
            }
            try
            {
                if (upd.to_delete.Count > 0)
                {
                    List<Crosscategory> toDelete = _context.Crosscategory.Where(x => x.IdProfile == upd.id && upd.to_delete.Contains(x.IdCategory)).ToList();
                    _context.RemoveRange(toDelete);
                    _context.SaveChanges();
                }
                if (upd.to_add.Count > 0)
                {
                    List<Crosscategory> toAdd = new List<Crosscategory>();
                    foreach (int a in upd.to_add)
                    {
                        toAdd.Add(new Crosscategory() { IdProfile = upd.id, IdCategory = a });
                    }
                    _context.Crosscategory.AddRange(toAdd);
                    _context.SaveChanges();
                }
                return Ok();
            }
            catch(Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

        [HttpPost]
        [Route("UpdateNeed")]
        public IActionResult UpdateNeed([FromBody]DTO_Auth_Obj t)
        {
            Update upd;
            try
            {
                upd = JsonConvert.DeserializeObject<Update>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удалось распознать полученный объект");
            }
            try
            {
                if (upd.to_delete.Count > 0)
                {
                    List<Crossneed> toDelete = _context.Crossneed.Where(x => x.IdProfile == upd.id && upd.to_delete.Contains(x.IdNeed)).ToList();
                    _context.RemoveRange(toDelete);
                    _context.SaveChanges();
                }
                if (upd.to_add.Count > 0)
                {
                    List<Crossneed> toAdd = new List<Crossneed>();
                    foreach (int a in upd.to_add)
                    {
                        toAdd.Add(new Crossneed() { IdProfile = upd.id, IdNeed = a });
                    }
                    _context.Crossneed.AddRange(toAdd);
                    _context.SaveChanges();
                }
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

        [HttpPost]
        [Route("UpdateTraining")]
        public IActionResult UpdateTraining([FromBody]DTO_Auth_Obj t)
        {
            Update upd;
            try
            {
                upd = JsonConvert.DeserializeObject<Update>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удалось распознать полученный объект");
            }
            try
            {
                if (upd.to_delete.Count > 0)
                {
                    List<Crosstraining> toDelete = _context.Crosstraining.Where(x => x.IdProfile == upd.id && upd.to_delete.Contains(x.IdTraining)).ToList();
                    _context.RemoveRange(toDelete);
                    _context.SaveChanges();
                }
                if (upd.to_add.Count > 0)
                {
                    List<Crosstraining> toAdd = new List<Crosstraining>();
                    foreach (int a in upd.to_add)
                    {
                        toAdd.Add(new Crosstraining() { IdProfile = upd.id, IdTraining = a });
                    }
                    _context.Crosstraining.AddRange(toAdd);
                    _context.SaveChanges();
                }
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

        [HttpPost]
        [Route("ChngStatuses/{id}/{mValue}/{hValue}/{houseType}/{heatType}")]
        public IActionResult ChangeForcedMigrant([FromBody]DTO_Auth_Obj t,int id,sbyte mValue,sbyte hValue,int houseType,int heatType)
        {
            try                 
            {
                Profile a = _context.Profile.Find(id);
                a.ForcedMigrant = mValue;
                a.DestroyedHouse = hValue;
                a.IdTypeHeating = heatType;
                a.IdTypeOfHouse = houseType;
                _context.SaveChanges();                
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

        [HttpPost]
        [Route("ChangeDestroyedHouse/{id}")]
        public IActionResult ChangeDestroyedHouse([FromBody]DTO_Auth_Obj t, int id)
        {
            try
            {
                Profile a = _context.Profile.Find(id);
                if (a.DestroyedHouse == 1) a.DestroyedHouse = 0;
                else if (a.DestroyedHouse == 0) a.DestroyedHouse = 1;
                _context.SaveChanges();
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

       

    }
}
